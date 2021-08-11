const ANY = "*"
const ONE = "."

type State struct {
	ChunksP []string
	MinLen  int
	HaveAny bool
}

func NewState(p string) (State, error) {
	s := State{}
	s.ChunksP = make([]string, 0)
	s.MinLen = 0
	lastLet := 0
	// 012345
	// ab*c
	// [ab * c]
	if p[0:1] == ANY {
		return s, errors.New("Incorrect p")
	}
	chunkI := -1
	for i := 0; i < len(p); i++ {
		s.MinLen++
		if p[i:i+1] == ANY {
			s.MinLen--
			s.HaveAny = true
			if lastLet != i-1 {
				s.ChunksP = append(s.ChunksP, string(p[lastLet:i-1]))
				chunkI++
			} else {
				if len(s.ChunksP) > 0 && s.ChunksP[chunkI] == p[i-1:i+1] {
					lastLet = i + 1
					// removing duplicating subsequent asteriscs
					continue
				}
			}
			lastLet = i + 1
			s.ChunksP = append(s.ChunksP, string(p[i-1:lastLet]))
			chunkI++
			continue
		}
	}
	if p[len(p)-1:len(p)] != ANY {
		s.ChunksP = append(s.ChunksP, string(p[lastLet:len(p)]))
	}

	return s, nil
}

func (state State) Check(chunkPi int, s string) bool {
	if chunkPi >= len(state.ChunksP) {
		return len(s) == 0
	}
	IsCurrentAny := false
	CurrentAnySym := ""
	v := state.ChunksP[chunkPi]
	if len(v) > 1 && string(v[len(v)-1:]) == ANY {
		IsCurrentAny = true
		CurrentAnySym = string(v[len(v)-2 : len(v)-1])
	}

	if !IsCurrentAny && len(v) > len(s) {
		return false
	}
	if IsCurrentAny {
		PreCheck := state.Check(chunkPi+1, s)
		if PreCheck {
			return true
		}
	}

	curI := 0
	for is, vs := range s {
		if IsCurrentAny {
			if !isSymbEqual(CurrentAnySym, string(vs)) {
				return state.Check(chunkPi+1, s[is:])
			}
			Check := state.Check(chunkPi+1, s[is:])
			if Check {
				return true
			}
		} else {
			if is >= len(v) {
				break
			}
			if !isSymbEqual(string(v[is:is+1]), string(vs)) {
				return false
			}
		}
		curI++
	}

	if chunkPi >= len(state.ChunksP) {
		return curI >= len(s)-1
	}

	return state.Check(chunkPi+1, s[curI:])
}

func isSymbEqual(s1, s2 string) bool {
	return s1 == s2 || s1 == ONE
}

func isMatch(s string, p string) bool {
	st, err := NewState(p)
	if err != nil {
		return false
	}
	fmt.Println(st.ChunksP, len(st.ChunksP))
	res := st.Check(0, s)
	fmt.Println(res)
	return res
}
