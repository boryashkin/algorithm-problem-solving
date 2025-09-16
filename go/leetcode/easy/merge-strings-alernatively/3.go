func mergeAlternately(word1 string, word2 string) string {
	i := 0
	j := 0
	var builder strings.Builder
	builder.Grow(len(word1) + len(word2))
	for _ = range max(len(word1), len(word2)) {
		if i < len(word1) {
			builder.WriteByte(word1[i])
			i++
		}
		if j < len(word2) {
			builder.WriteByte(word2[j])
			j++
		}
	}

	return builder.String()
}