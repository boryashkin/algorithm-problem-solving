package main

import "fmt"

/*
The task was about to encode/decode a string by shifting letters by k positions in the alphabet in direction d with wrap-around. But i don't remember test-cases
*/

/**
 * 01234567890123456789012345
 * ABCDEFGHIJKLMNOPQRSTUVWXYZ
 **/
func main() {
	tests := []string{"A", "ABC", "Z", "Z", "A", "A", "AZY"}
	results := []string{"K", "KLM", "A", "B", "Z", "Y", "DCB"}
	ds := []int{1, 1, 1, 1, -1, -1, 1}
	ks := []int{10, 10, 1, 2, 1, 2, 3}

	for i, _ := range tests {
		r := run(tests[i], ds[i], ks[i])
		if r != results[i] {
			fmt.Println(i, "FAIL", fmt.Sprintf("%s (%s + %d) != %s", results[i], tests[i], ds[i]*ks[i], r))
			continue
		}

		fmt.Println(i, "SUCCESS")
	}

}

func run(m string, d int, k int) string {
	a := int(rune('A')) // 65
	z := int(rune('Z')) // 90 (90-65=25)
	// 65 - 1 = 64; == 89 (k = -1, but the same as +24)
	// 65 - 2 = 63; == 88 (k = -2, but the same as +23)
	// 90 + 1 = 91; == 66 (k = 1, but it's the same as -24)
	// 90 + 10 = 10; == 75 (k = 10, but it's the same as -15)

	new := []rune{}
	for _, l := range m {
		newSymbol := int(l) + (d*k)%(z-a)

		if newSymbol < a && newSymbol < z {
			newSymbol = z + (newSymbol - a) + 1
		} else if newSymbol > z {
			newSymbol = a + (newSymbol - z) - 1
		}

		new = append(new, rune(newSymbol))
	}
	// fmt.Fprintln(os.Stderr, "Debug messages...")
	return string(new) // Write answer to stdout
}
