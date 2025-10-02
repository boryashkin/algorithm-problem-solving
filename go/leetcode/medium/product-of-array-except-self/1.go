// had to look up a hint about left-right approach
func productExceptSelf(nums []int) []int {
	answer := make([]int, len(nums))
	for i, _ := range answer {
		answer[i] = 1
	}

	accum := 1
	for i, v := range nums {
		answer[i] *= accum
		accum *= v
	}

	accum = 1
	for i := len(nums) - 1; i >= 0; i-- {
		answer[i] *= accum
		accum *= nums[i]
	}

	return answer
}

// fails with a timeout
func productExceptSelfNaive(nums []int) []int {
	answer := make([]int, len(nums))

	for i, _ := range answer {
		answer[i] = 1
	}

	for i, v := range nums {
		for j, _ := range answer {
			if i == j {
				continue
			}

			answer[j] *= v
		}
	}

	return answer
}