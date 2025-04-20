package main

import (
	"bufio"
	"flag"
	"fmt"
	"github.com/google/gousb"
	"github.com/r3labs/sse/v2"
	"log"
	// "math/rand" // No longer needed for mock mode
	"net/http"
	"os"
	"strconv"
	"strings"
	"time"
)

var mockMode bool

// Predefined RFID codes for mock mode
var mockRFIDCodes = []string{
	"1234567890",
	"0987654321",
	"1122334455",
	"5544332211",
	"1010101010",
	"2020202020",
	"3030303030",
	"4040404040",
	"5050505050",
	"6060606060",
}

func init() {
	flag.BoolVar(&mockMode, "mock", false, "Enable mock mode to simulate RFID scans via terminal input (0-9)")
	flag.Parse()
	// rand.Seed(time.Now().UnixNano()) // No longer needed for mock mode
}

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

	if mockMode {
		fmt.Println("Running in mock mode. Enter a digit (0-9) and press Enter to simulate an RFID scan.")
		runMockMode(server)
	} else {
		fmt.Println("Running in RFID reader mode.")
		runRFIDReader(server)
	}
}

func runMockMode(server *sse.Server) {
	reader := bufio.NewReader(os.Stdin)
	for {
		fmt.Print("Enter digit (0-9): ")
		input, err := reader.ReadString('\n')
		if err != nil {
			log.Printf("Error reading from stdin: %v", err)
			continue
		}

		input = strings.TrimSpace(input)

		if len(input) != 1 {
			fmt.Println("Invalid input. Please enter a single digit (0-9).")
			continue
		}

		index, err := strconv.Atoi(input)
		if err != nil || index < 0 || index > 9 {
			fmt.Println("Invalid input. Please enter a single digit (0-9).")
			continue
		}

		mockData := mockRFIDCodes[index]

		fmt.Printf("Simulating scan: %s\n", mockData)
		server.Publish("current", &sse.Event{
			Data: []byte(mockData),
		})
	}
}

func runRFIDReader(server *sse.Server) {
	ctx := gousb.NewContext()
	defer ctx.Close()

	// Replace with your RFID reader's VID and PID
	dev, err := ctx.OpenDeviceWithVIDPID(0xffff, 0x0035)
	if err != nil {
		log.Fatalf("Could not open a device: %v. Is it connected?", err)
	}
	if dev == nil {
		log.Fatalf("Device with VID 0xffff, PID 0x0035 not found.")
	}

	err = dev.SetAutoDetach(true)
	if err != nil {
		log.Fatalf("SetAutoDetach failed: %v", err)
	}
	defer dev.Close()

	intf, done, err := dev.DefaultInterface()
	if err != nil {
		log.Fatalf("Could not claim default interface: %v", err)
	}
	defer done()

	ep, err := intf.InEndpoint(1) // Assuming endpoint address 0x81 (IN endpoint 1)
	if err != nil {
		log.Fatalf("Could not get IN endpoint 1: %v", err)
	}

	aggregated := make([]byte, 0, 11) // Use a slice with capacity
	buf := make([]byte, 16)           // Buffer size might need adjustment based on device

	stream, err := ep.NewStream(32*1024, 1) // Adjust buffer size and transfers as needed
	if err != nil {
		log.Fatalf("Could not create read stream: %v", err)
	}
	defer stream.Close()

	fmt.Println("Waiting for RFID scans...")

	for {
		n, err := stream.Read(buf)
		if err != nil {
			// Handle potential errors like timeouts or disconnections gracefully
			if  _, ok := err.(gousb.Error); ok {
				continue // Ignore timeouts, just keep trying
			}
			log.Printf("Read error: %v", err)
			// Consider adding a delay or attempting to reconnect here
			time.Sleep(1 * time.Second)
			continue
		}

		if n < 3 { // Ensure buffer has enough data for buf[2]
			continue
		}

		// Assuming the relevant byte is always at index 2
		// This logic might need adjustment based on your specific RFID reader's protocol
		keyPressByte := buf[2]

		// Filter out potential "key release" events or noise if byte is 0
		if keyPressByte == 0 {
			continue
		}

		aggregated = append(aggregated, keyPressByte)

		// Check if we have collected 11 bytes (assuming 10 digits + enter/terminator)
		if len(aggregated) == 11 {
			result := ""
			for i, b := range aggregated {
				if i == 10 { // Skip the last byte (assumed terminator)
					break
				}
				// Decode the key press byte to a digit (adjust this logic for your reader)
				// This example assumes a specific keyboard mapping where digits 1-9 map to 30-38, 0 maps to 39
				digit := -1 // Use -1 to indicate invalid byte
				if b >= 30 && b <= 38 { // 1-9
					digit = int(b - 29)
				} else if b == 39 { // 0
					digit = 0
				} else {
					// Handle unexpected byte values if necessary
					log.Printf("Warning: Unexpected byte value %d in sequence", b)
					result = "" // Invalidate sequence on error
					break
				}
				result += strconv.Itoa(digit)
			}

			if len(result) == 10 { // Only publish if we successfully decoded 10 digits
				fmt.Printf("RFID Scanned: %s\n", result)
				server.Publish("current", &sse.Event{
					Data: []byte(result),
				})
			} else if result != "" { // Log warning only if sequence wasn't invalidated by bad byte
				log.Printf("Warning: Decoded sequence length is not 10: %d bytes, data: %s", len(aggregated)-1, result)
			}

			// Reset for the next scan
			aggregated = make([]byte, 0, 11)
		}
	}
}
