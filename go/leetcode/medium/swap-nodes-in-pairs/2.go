func swapPairs(head *ListNode) *ListNode {
	if head == nil || head.Next == nil {
		return head
	}

	// h(1)
	// l  r  n
	// 1->2->3->4->
	// l(1) r(2) h(3)
	// l(1)->(3); r(2)->(1); p(1)
	// l(3) r(4) h(5)
	// l(3)->(5); r(4)->(3); p(1)->(4); p(3)
	newHead := head.Next
	var prev *ListNode
	for {
		if head == nil || head.Next == nil {
			break
		}
		lH := head
		rH := head.Next
		rHn := rH.Next
		head = rHn
		lH.Next = rHn
		rH.Next = lH
		if prev != nil {
			prev.Next = rH
		}
		prev = lH
	}

	return newHead
}