/**
 * Definition for singly-linked list.
 * type ListNode struct {
 *     Val int
 *     Next *ListNode
 * }
 */
func mergeTwoLists(list1 *ListNode, list2 *ListNode) *ListNode {
	if list1 == nil {
		return list2
	}
	if list2 == nil {
		return list1
	}

	var head *ListNode
	var lesserNode *ListNode
	var biggerNode *ListNode
	if list1.Val < list2.Val {
		head = list1
		lesserNode = list1
		biggerNode = list2
	} else {
		head = list2
		lesserNode = list2
		biggerNode = list1
	}

	for {
		if lesserNode.Next == nil {
			lesserNode.Next = biggerNode
			break
		}

		if lesserNode.Next.Val < biggerNode.Val {
			lesserNode = lesserNode.Next
			continue
		} else {
			// lesserNode->lesserNext->lesserNextNext
			// biggerNode->biggerNext->biggerNextNext
			// pop <-> [1]
			// lesserNode->[biggerNode]->[lesserNext]->lesserNextNext
			// biggerNext->biggerNextNext
			// [2]
			// [biggerNode]->[lesserNext]->lesserNextNext
			// biggerNext->biggerNextNext

			// 1->2->4
			// 1->3->4
			// change <->
			// 1->1->4
			// 2->3->4
			// change <->
			// 1->1->2->4
			// 3->4
			// change <->
			// 1->1->2->3->4
			// 4
			// 1->1->2->3->4->4

			lesserNext := lesserNode.Next
			var biggerNext *ListNode
			if biggerNode.Next != nil {
				biggerNext = biggerNode.Next
			}

			biggerNode.Next = lesserNext
			lesserNode.Next = biggerNode

			lesserNode = lesserNode.Next
			biggerNode = biggerNext
			if biggerNode == nil {
				break
			}
			continue
		}
	}

	return head
}