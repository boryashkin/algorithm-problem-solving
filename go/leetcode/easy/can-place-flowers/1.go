//1,0,0,0,0,0,0 = 1
//f,f,f,t
//0 = 1 (1) 1/2=0 1%2=1
//0,0 = 1 (2) 2/2=1 2%2=0
//0,0,0 = 2 (3) 3/2=1 3%2=1
//0,0,0,0 = 2 (4) 3/2=2 3%2=0
//0,0,0,0,0 = 3 (5) 5/2=2 5%2=1
//0,0,0,0,0,0 = 3 (6) 6/2=3 6%2=0
//0,0,0,0,0,0,0 = 4 (7) 7/2=3 7%2=1
// n/2=x n%2=y, slots = x+y

// edge - 1 border
// 0 vs 1,0 or 1,0,1 or 0,1 | 1 vs 0
// 0,0 vs 1,0,0 or 0,0,1 OR 1,0,0,1 | 1 vs 1 OR 0
// 0,0,0 vs 0,0,0,1 or 1,0,0,0,1 or 0,0,0,1 | 2 vs 1
// 0,0,0,0 vs 0,0,0,0,1 or 1,0,0,0,0,1 or 1,0,0,0,0 | 2 vs 2 OR 1
// 0,0,0,0,0 vs 0,0,0,0,0,1 or 1,0,0,0,0,0,1 or 1,0,0,0,0,0 | 3 or 2
// 0,0,0,0,0,0 vs 0,0,0,0,0,0,1 or 1,0,0,0,0,0,0,1 or 1,0,0,0,0,0,0 | 3 or 3 OR 2
func canPlaceFlowers(flowerbed []int, n int) bool {
	var slots int

	var isAdjacentTo1 bool  // true = contiguos0s%2==1 => result-1
	var isEnclosedBy1s bool // true = result-1

	var contiguos0s int

	calcSlots := func(contiguos0s int, isAdjacentTo1, isEnclosedBy1s bool) int {
		curSlots := 0
		x := contiguos0s / 2
		y := contiguos0s % 2
		curSlots = x + y

		if curSlots == 0 {
			return 0
		}

		if isEnclosedBy1s {
			curSlots -= 1
		} else if isAdjacentTo1 && y > 0 {
			curSlots -= 1
		}

		return curSlots
	}

	for _, v := range flowerbed {
		if v == 1 {
			if isAdjacentTo1 {
				isEnclosedBy1s = true
			}
			isAdjacentTo1 = true

			slots += calcSlots(contiguos0s, isAdjacentTo1, isEnclosedBy1s)

			contiguos0s = 0
		} else {
			contiguos0s++
			isEnclosedBy1s = false
		}
	}

	if contiguos0s > 0 {
		slots += calcSlots(contiguos0s, isAdjacentTo1, isEnclosedBy1s)
	}

	return slots >= n
}