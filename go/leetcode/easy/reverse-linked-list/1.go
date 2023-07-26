func reverseList(head *ListNode) *ListNode {
	cur, newHead := reverse(head)
	if cur != nil {
		cur.Next = nil
	}
	return newHead
}

func reverse(head *ListNode) (*ListNode, *ListNode) {
	if head == nil || head.Next == nil {
		return head, head
	}

	nHead, nnHead := reverse(head.Next)
	nHead.Next = head

	return head, nnHead
}