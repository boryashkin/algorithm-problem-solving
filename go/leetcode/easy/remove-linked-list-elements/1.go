func removeElements(head *ListNode, val int) *ListNode {
	if head == nil || (head.Val != val && head.Next == nil) {
		return head
	}
	if head.Val == val {
		head = removeElements(head.Next, val)
	} else {
		head.Next = removeElements(head.Next, val)
	}

	return head
}