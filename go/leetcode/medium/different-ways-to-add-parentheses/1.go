func diffWaysToCompute(expression string) []int {
	nums, ops := parseExpression(expression)
	//fmt.Println(nums, OpsAsStrings(ops))

	return solve(nums, ops, 0, len(nums))
}

type Op rune

func OpsAsStrings(ops []Op) []string {
	str := []string{}
	for _, v := range ops {
		str = append(str, string(v))
	}
	return str
}

func solve(nums []int, ops []Op, num int, initialNumsLen int) []int {
	//fmt.Println("<solve call>", nums, OpsAsStrings(ops), num)
	result := []int{}
	if len(nums) < 1 || len(ops) < 1 {
		return nums
	}
	if len(nums) == 1 {
		return nums
	}
	if len(ops) == 1 { // and len(nums) == 2
		if ops[0] == Op('+') {
			return []int{nums[0] + nums[1]}
		}
		if ops[0] == Op('-') {
			return []int{nums[0] - nums[1]}
		}
		if ops[0] == Op('*') {
			return []int{nums[0] * nums[1]}
		}
	}

	for i := num; i < len(ops); i++ {
		lOps := append([]Op{}, ops[:i]...)
		lNums := append([]int{}, nums[:len(lOps)+1]...)
		curOp := ops[i]

		rOps := append([]Op{}, ops[i+1:]...)
		rNums := append([]int{}, nums[len(lNums):]...)

		//fmt.Println("L solve()", lNums, OpsAsStrings(lOps), string(curOp))
		lSolutions := solve(lNums, lOps, 0, initialNumsLen)
		//fmt.Println("L lSolutions=", lSolutions)
		//fmt.Println("R solve()", rNums, OpsAsStrings(rOps), string(curOp))
		rSolutions := solve(rNums, rOps, 0, initialNumsLen)
		//fmt.Println("R rSolutions=", rSolutions)
		for _, lR := range lSolutions {
			for _, rR := range rSolutions {
				//fmt.Println("sol", lR, rR, string(curOp))
				lrNums := append([]int{}, lR)
				lrNums = append(lrNums, rR)
				lrResult := solve(lrNums, []Op{curOp}, 0, initialNumsLen)
				result = append(result, lrResult...)
				// if initialNumsLen == len(nums) {
				// 	fmt.Println("<heart solve result>", lrNums, string(curOp), num, lrResult)
				// }
			}
		}

	}
	return result
}

func parseExpression(expression string) ([]int, []Op) {
	num := 0
	nums := []int{}
	ops := []Op{}

	for _, v := range expression {
		if v >= rune('0') && v <= rune('9') {
			num = num*10 + int(v-rune('0'))
			continue
		}
		nums = append(nums, num)

		// to parse the next num
		num = 0
		// if v == rune('+')
		// if v == rune('-')
		// if v == rune('*')
		ops = append(ops, Op(v))
	}
	nums = append(nums, num)

	return nums, ops
}