func countGoodSubstrings(s string) int {
	lenS := len(s)
	if lenS < 3 {
		return 0
	}


	wordsCnt := 0
	for i, _ := range s {
		if i+2 >= lenS {
			break
		}
		if s[i] != s[i+1] && s[i] != s[i+2] && s[i+1] != s[i+2] {
			wordsCnt++
		}
	}

	return wordsCnt
}