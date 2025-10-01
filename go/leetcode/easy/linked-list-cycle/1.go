/**
* Definition for singly-linked list.
* type ListNode struct {
*     Val int
*     Next *ListNode
* }
*/
func hasCycle(head *ListNode) bool {
    var flag, cur *ListNode
    var i int
    cur = head
    flag = head
    for cur != nil {
        if i % 2 != 0 {
            flag = flag.Next
        }
        i++
        cur = cur.Next
        if flag == cur {
            return true
        }
    }
    return false
}