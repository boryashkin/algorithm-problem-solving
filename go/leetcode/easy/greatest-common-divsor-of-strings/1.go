// at first my idea was to iterate over strings and accumulate the common substring
// by looking back at the start symbol, and if the "repeat" is started
// but it breaks on cases like OBCNO
// then i just started to look at it mathematically
func gcdOfStrings(str1 string, str2 string) string {
	var maxStr, minStr string

	if len(str1) > len(str2) {
		maxStr = str1
		minStr = str2
	} else {
		maxStr = str2
		minStr = str1
	}

	// check if minStr is a subset in the first place
	for i := range min(len(maxStr), len(minStr)) {
		if maxStr[i] != minStr[i] {
			return ""
		}
	}

	// the min common divisor is the length of t
	// 6, 6, 65
	// 3, 4, 40
	foundT := false
	t := ""
	for l := len(minStr); l > 0; l-- {
		if len(maxStr)%l == 0 && len(minStr)%l == 0 {
			foundT = true
			t = string(minStr[:l])
			break
		}
	}

	if !foundT {
		return ""
	}

	for i := range len(maxStr) {
		// we can add || t[i%len(t)] != maxStr[i] here instead the first loop
		if t[i%len(t)] != maxStr[i] {
			return ""
		}
	}

	return t
}