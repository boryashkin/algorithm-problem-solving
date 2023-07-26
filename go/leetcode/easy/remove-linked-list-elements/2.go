func removeElements(head *ListNode, val int) *ListNode {
	if head == nil || (head.Val != val && head.Next == nil) {
		return head
	}

	var mainHead *ListNode
	var prev *ListNode
	// 1->2->6->3->4
	// h(1): mh(1) p(1) h(2)
	// h(2): p(1)->(2) p(2) h(6)
	// h(6): h(3)
	// h(3): p(2)->(3) p(3) h(4)
	// h(4): p(3)->(4) p(4) h(-)

	// 6->1->2
	for {
		if head == nil {
			break
		}
		if head.Val == val {
			if head.Next == nil && prev != nil {
				prev.Next = nil
			}
			head = head.Next
			continue
		}
		if mainHead == nil {
			mainHead = head
		}

		if prev != nil {
			prev.Next = head
		}
		prev = head
		head = head.Next
	}

	return mainHead
}