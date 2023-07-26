func isPalindrome(head *ListNode) bool {
	i := 0
	firstHead := head
	for {
		if head == nil {
			break
		}
		head = head.Next
		i++
	}
	if i < 2 {
		return true
	}

	// 1-2-1 [1|1]; 1-2-3-2-1 [2|1]; 1-2-3-4-5-4-3-2-1 [4|1] // odd
	// 1-2-2-1 [2|0]; 1-2-3-3-2-1 [3|0] // even
	len := i / 2        // 1
	lastFrom := len + 1 // 2
	if i%2 != 0 {
		lastFrom += 1 // 3
	}
	k := 1 // unlike i (a counter) k is an index starting from 1
	middleHead := firstHead
	for {
		if k >= lastFrom {
			break

		}
		middleHead = middleHead.Next
		k++
	}

	lastHead := reverseList(middleHead)

	return areListsEqual(firstHead, lastHead, len)
}

func areListsEqual(first *ListNode, last *ListNode, len int) bool {
	for i := 0; i < len; i++ {
		if first == nil || last == nil {

			return false
		}
		if first.Val != last.Val {
			return false
		}
		first = first.Next
		last = last.Next
	}
	return true
}

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