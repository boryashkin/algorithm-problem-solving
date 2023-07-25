
func swapPairs(head *ListNode) *ListNode {
	if head == nil || head.Next == nil {
		return head
	}
	newNextNext := swapPairs(head.Next.Next)
	newHead := head.Next
	newHead.Next = head
	newHead.Next.Next = newNextNext
	return newHead
}