//12 - 21
// 123 - 321
// 1234 - 4321
// 12345 - 54321
func reverseVowels(s string) string {
	result := []byte(s)

	i := 0
	j := len(s) - 1

	for i < j {
		iv := isVowelB(result[i])
		jv := isVowelB(result[j])
		if iv && jv {
			m := result[i]
			result[i] = result[j]
			result[j] = m
		} else {
			// cancel out
			if iv {
				i--
			}
			if jv {
				j++
			}
		}

		i++
		j--
	}

	return string(result)
}

func isVowel(b byte) bool {
	return b == 'a' ||
		b == 'e' ||
		b == 'i' ||
		b == 'o' ||
		b == 'u' ||

		b == 'A' ||
		b == 'E' ||
		b == 'I' ||
		b == 'O' ||
		b == 'U'
}

func isVowelB(b byte) bool {
	b &= 0b11011111 // upper case ASCII

	return b == 'A' ||
		b == 'E' ||
		b == 'I' ||
		b == 'O' ||
		b == 'U'
}