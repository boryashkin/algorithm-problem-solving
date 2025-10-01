func reverseWords(s string) string {
	var result []byte

	var isOnWord bool
	startOfW := -1

	// "  a ab abc  "
	// "abc"
	for i := len(s) - 1; i >= -1; i-- {
		if i >= 0 && s[i] != ' ' {
			if isOnWord == false {
				isOnWord = true
				startOfW = i
				if len(result) > 0 {
					result = append(result, ' ')
				}
			}

			continue
		}

		// else
		if isOnWord == true {
			isOnWord = false
			result = append(result, s[i+1:startOfW+1]...)

			startOfW = -1
		}
	}

	return string(result)
}