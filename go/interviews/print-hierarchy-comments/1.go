package main

import (
	"fmt"
	"strconv"
)

type Comment struct {
	id     int
	parent int
}

func main() {
	// 1
	//   4
	//     7
	// 2
	//   6
	// 3
	//   5
	//     8
	//       9
	var list = []Comment{
		{0, 0},
		{1, 0},
		{2, 0},
		{3, 0},
		{4, 1},
		{5, 3},
		{6, 2},
		{7, 4},
		{8, 5},
		{9, 8},
	}

	fmt.Println(printHierarchy(list))
}

func printHierarchy(comments []Comment) string {
	return recPrint(0, 0, comments)
}

func recPrint(level int, parent int, list []Comment) string {
	result := ""

	for _, v := range list {
		if v.parent != parent {
			continue
		}
		result += strconv.Itoa(v.id) + "\n"
		if v.id == parent {
			continue
		}
		result += recPrint(level+1, v.id, list)
	}
	prefix := ""
	if result != "" {
		for i := 0; i < level; i++ {
			prefix += "- "
		}
	}

	return prefix + result
}
