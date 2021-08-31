package binary_tree_inorder_traversal

/**
 * Definition for a binary tree node.
 * type TreeNode struct {
 *     Val int
 *     Left *TreeNode
 *     Right *TreeNode
 * }
 */
func inorderTraversal(root *TreeNode) []int {
	result := make([]int, 0)
	stack := make([]*TreeNode, 0)

	stack = append(stack, root)
	for i := 0; i >= 0; i-- {
		if stack[i] == nil {
			continue
		}
		cur := stack[i]
		if cur.Left != nil {
			if len(stack) > i+1 {
				stack[i+1] = cur.Left
			} else {
				stack = append(stack, cur.Left)
			}
			stack[i].Left = nil
			i = i + 2
			continue
		}
		result = append(result, cur.Val)
		stack[i] = nil
		if cur.Right != nil {
			stack[i] = cur.Right
			i++
		}
	}

	return result
}
