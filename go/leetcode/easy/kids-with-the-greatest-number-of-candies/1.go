func kidsWithCandies(candies []int, extraCandies int) []bool {
	var max int

	for _, v := range candies {
		if max < v {
			max = v
		}
	}

	result := make([]bool, len(candies))

	for i, v := range candies {
		result[i] = v+extraCandies >= max
	}

	return result
}