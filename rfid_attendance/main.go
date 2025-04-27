package main

import (
	"bufio"
	"flag"
	"fmt"
	"github.com/google/gousb"
	"github.com/r3labs/sse/v2"
	"log"
	"net/http"
	"os"
	"strconv"
	"strings"
)

func main() {
	// command-line flag
	mock := flag.Bool("mock", false, "Enable mock mode (enter digits 0-9 to publish preset RFIDs)")
	flag.Parse()

	// SSE server setup
	server := sse.New()
	server.AutoReplay = false
	server.CreateStream("current")

	mux := http.NewServeMux()
	mux.HandleFunc("/stream/current", func(w http.ResponseWriter, r *http.Request) {
		w.Header().Add("Access-Control-Allow-Origin", "*")
		server.ServeHTTP(w, r)
	})

	go func() {
		fmt.Println("Serving SSE on :8081")
		if err := http.ListenAndServe(":8081", mux); err != nil {
			log.Fatalf("HTTP server error: %v", err)
		}
	}()

	if *mock {
		runMockMode(server)
	} else {
		runRealMode(server)
	}
}

func runMockMode(server *sse.Server) {
	fmt.Println("MOCK MODE: enter digit 0-9, or 'exit' to quit")
	// define your preset RFIDs here
	preset := map[string]string{
		"0": "0000000001",
		"1": "1111111111",
		"2": "2222222222",
		"3": "3333333333",
		"4": "4444444444",
		"5": "5555555555",
		"6": "6666666666",
		"7": "7777777777",
		"8": "8888888888",
		"9": "9999999999",
	}

	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		text := strings.TrimSpace(scanner.Text())
		if text == "exit" {
			fmt.Println("Exiting mock mode.")
			return
		}
		if rfid, ok := preset[text]; ok {
			fmt.Printf("Publishing mock RFID %q\n", rfid)
			server.Publish("current", &sse.Event{Data: []byte(rfid)})
		} else {
			fmt.Println("Please enter a single digit 0-9 or 'exit'")
		}
	}
	if err := scanner.Err(); err != nil {
		log.Printf("stdin error: %v", err)
	}
}

func runRealMode(server *sse.Server) {
	ctx := gousb.NewContext()
	defer ctx.Close()

	// Replace with your RFID reader's VID/PID
	dev, err := ctx.OpenDeviceWithVIDPID(0xffff, 0x0035)
	if err != nil {
		log.Fatalf("Could not open device: %v", err)
	}
	dev.SetAutoDetach(true)
	defer dev.Close()

	intf, done, err := dev.DefaultInterface()
	if err != nil {
		log.Fatalf("Could not claim interface: %v", err)
	}
	defer done()

	ep, err := intf.InEndpoint(1)
	if err != nil {
		log.Fatalf("Endpoint error: %v", err)
	}

	aggregated := make([]byte, 11)
	buf := make([]byte, 16)
	iter := 0

	for {
		n, err := ep.Read(buf)
		if err != nil {
			log.Fatalf("Read error: %v", err)
		}

		if n > 2 {
			aggregated[iter] = buf[2]
		}

		iter++

		if iter%11 == 0 {
			result := ""
			for i, b := range aggregated {
				if i == 10 {
					break
				}

				digit := int((b-30)+1) % 10
				result += strconv.Itoa(digit)
			}
			fmt.Println("Scanned RFID:", result)
			server.Publish("current", &sse.Event{Data: []byte(result)})
			aggregated = make([]byte, 11)
			iter = 0
		}
	}
}
