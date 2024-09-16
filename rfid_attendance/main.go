package main

import (
	"fmt"
	"github.com/google/gousb"
	"github.com/r3labs/sse/v2"
	"log"
	"net/http"
	"strconv"
)

func main() {
	server := sse.New()
    server.AutoReplay = false

	server.CreateStream("current")

	mux := http.NewServeMux()
	mux.HandleFunc("/stream/current", func(w http.ResponseWriter, r *http.Request) {
		w.Header().Add("Access-Control-Allow-Origin", "*")

		server.ServeHTTP(w, r)
	})

	go func() {
		fmt.Println("Serving :8081")
		http.ListenAndServe(":8081", mux)
	}()

	ctx := gousb.NewContext()
	defer ctx.Close()

	// Replace with your RFID reader's VID and PID
	dev, err := ctx.OpenDeviceWithVIDPID(0xffff, 0x0035)
	if err != nil {
		log.Fatalf("Could not open a device: %v", err)
	}

	dev.SetAutoDetach(true)
	defer dev.Close()

	intf, done, err := dev.DefaultInterface()
	if err != nil {
		log.Fatalf("Could not claim interface: %v", err)
	}
	defer done()

	aggregated := make([]byte, 11)

	buf := make([]byte, 16)
	iter := 0

	for {
		n, err := intf.InEndpoint(1)
		n.Read(buf)

		aggregated[iter] = buf[2]
		if err != nil {
			log.Fatalf("Read error: %v", err)
		}

		iter++

		if iter%11 == 0 {
			result := ""

			for i, byte := range aggregated {
				if i == 10 {
					break
				}

				result += strconv.Itoa(int((byte-30)+1) % 10)
			}

			server.Publish("current", &sse.Event{
				Data: []byte(result),
			})

			aggregated = make([]byte, 11)
			iter = 0
		}
	}
}
