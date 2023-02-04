/**
* Definition for singly-linked list.
* type ListNode struct {
*     Val int
*     Next *ListNode
* }
*/
func mergeKLists(lists []*ListNode) *ListNode {
    unsortedList := prepareSingleUnsortedList(lists)
    return mergeSort(unsortedList)
}
func mergeSort(list *ListNode) *ListNode {
    if list == nil || list.Next == nil {
        return list
    }
    left, right := split(list)

    return merge(mergeSort(left), mergeSort(right))
}

func merge(left *ListNode, right *ListNode) *ListNode {
    sortedList := &ListNode{Val: -999}
    sp := sortedList
    l := left
    r := right

    for l != nil || r != nil {
        if l == nil {
            sp.Next = r
            r = r.Next
        } else if r == nil {
            sp.Next = l
            l = l.Next
        } else {
            if l.Val > r.Val {
                sp.Next = r
                r = r.Next
            } else {
                sp.Next = l
                l = l.Next
            }
        }
        sp = sp.Next
    }
    return sortedList.Next
}

func split(list *ListNode) (*ListNode, *ListNode) {
    length := 0
    l := list
    for l.Next != nil {
        length += 1
        l = l.Next
    }
    midpoint := length / 2
    length = 0
    left := list
    var right *ListNode
    for list.Next != nil {
        if length >= midpoint {
            right = list.Next
            list.Next = nil
            break
        }
        length += 1
        list = list.Next
    }

    return left, right
}

func prepareSingleUnsortedList(lists []*ListNode) *ListNode {
    if len(lists) == 1 {
        return lists[0]
    }
    if len(lists) == 0 {
        return nil
    }
    var head *ListNode
    var current *ListNode
    for _, l := range lists {
        if l == nil {
            continue
        }
        if head == nil {
            head = l
        }
        if current != nil {
            current.Next = l
        }
        current = l
        for current.Next != nil {
            current = current.Next
        }
    }

    return head
}