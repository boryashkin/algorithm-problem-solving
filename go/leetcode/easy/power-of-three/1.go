func isPowerOfThree(n int) bool {
	if n == 1 {
		return true
	}
	if n < 1 || n%3 != 0 {
		return false
	}

	return isPowerOfThree(n / 3)
}