func merge(nums1 []int, m int, nums2 []int, n int) {
	if n == 0 {
		return
	}

	j := 0
	for i := 0; i < len(nums1); i++ {
		if i > m-1 {
			nums1[i] = nums2[j]
			j++
			continue
		}

		if nums1[i] > nums2[j] {
			swap := nums1[i]
			nums1[i] = nums2[j]
			nums2[j] = swap
			swapSort(nums2)
			continue
		}
	}
}

func swapSort(nums []int) {
	for i := 0; i < len(nums); i++ {
		if i+1 >= len(nums) {
			return
		}

		if nums[i] > nums[i+1] {
			swap := nums[i]
			nums[i] = nums[i+1]
			nums[i+1] = swap
		} else {
			break // an optimization for our case
		}
	}
}