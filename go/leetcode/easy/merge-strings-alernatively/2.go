func mergeAlternately(word1 string, word2 string) string {
	i := 0
	j := 0
	var builder strings.Builder
	for {
		if i < len(word1) {
			builder.WriteByte(word1[i])
			i++
		}
		if j < len(word2) {
			builder.WriteByte(word2[j])
			j++
		}

		if i >= len(word1) && j >= len(word2) {
			break
		}
	}

	return builder.String()
}