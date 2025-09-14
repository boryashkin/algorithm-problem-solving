/*
You are a famous architect that creates special houses composed of only squared rooms.

When a rich client wants to build a new house, he knows exactly the size of the house he wants to build, and needs you to identify the size of all rooms that he can have.
He always wants the biggest possible rooms. for example, he prefers having one room of size 4x4 (16m²) instead of 4 rooms of size 2x2 (4m²x4).
Input
Surface : the number of square meters for the total house
Output
Several lines.
Each line contains a number Size representing the size of the side (in meters) of a room in the house, sorted in descending order
Constraints
1 <= Surface <= 10000

*/

package main

import (
	"fmt"
	"math"
)

/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/
func main() {
	var surface int
	fmt.Scan(&surface)

	/*
	   99: 9*9=81
	   99-81=18: 4*4=16
	   18-16=2: 1
	*/

	result := []int{}

	for {
		if surface <= 0 {
			break
		}

		maxSideF := math.Sqrt(float64(surface))
		maxSide := int(maxSideF)
		result = append(result, maxSide)
		surface -= maxSide * maxSide
	}

	for _, v := range result {
		fmt.Printf("%d\n", v)
	}
}
