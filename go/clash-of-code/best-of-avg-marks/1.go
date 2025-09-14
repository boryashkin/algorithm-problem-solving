/*
You have to calculate the average marks by people and after print the name of the person with the best average. All people have the same amount of marks.

Input
Line 1: An integer that represent the number of people
Other lines: Name of the person,Mark_1,Mark_2, etc.
The mark should be 0 ≤ marks ≤ 20
Output
The first name of the person with the best average and the average.
If there is an error in the marks you have to display Problem with marks of the concerned person
*/
package main

import (
	"bufio"
	"fmt"
	"os"
	"strconv"
	"strings"
)

/**
 * DIDN'T solve in time, used Atoi at first, but got an error on '10.0' which was an invalid mark according to the task
 * So I switched to ParseInt, but didn't have time to test it
 **/

func main() {
	scanner := bufio.NewScanner(os.Stdin)
	scanner.Buffer(make([]byte, 1000000), 1000000)

	var numberofpeople int
	scanner.Scan()
	fmt.Sscan(scanner.Text(), &numberofpeople)

	maxMark := float64(0)
	maxName := ""

	for i := 0; i < numberofpeople; i++ {
		scanner.Scan()
		x := scanner.Text()

		arr := strings.Split(x, ",")

		name := arr[0]
		snum := float64(0)
		markCount := len(arr) - 1

		for i, v := range arr {
			if i == 0 {
				continue
			}

			num, err := strconv.ParseInt(v, 10, 64)
			if err != nil {
				fmt.Printf("Problem with marks of: %s", name)
				return
			}
			fnum := float64(num)

			snum += fnum
		}
		snum /= float64(markCount)

		if snum > maxMark {
			maxMark = snum
			maxName = name
		}
	}

	// fmt.Fprintln(os.Stderr, "Debug messages...")
	fmt.Printf("%s,%.1f", maxName, maxMark) // Write answer to stdout
}
