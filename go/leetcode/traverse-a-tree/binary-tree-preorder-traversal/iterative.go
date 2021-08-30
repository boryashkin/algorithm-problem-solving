package binary_tree_preorder_traversal

/**
 * Definition for a binary tree node.
 * type TreeNode struct {
 *     Val int
 *     Left *TreeNode
 *     Right *TreeNode
 * }
 */
func preorderTraversal(root *TreeNode) []int {
	result := make([]int, 0)
	if root == nil {
		return result
	}

	stack := make([]*TreeNode, 0)
	stack = append(stack, root)

	for i := 0; i >= 0; i-- {
		cur := stack[i]
		stack[i] = nil
		for cur.Left != nil {
			result = append(result, cur.Val)
			if cur.Right != nil {
				if i >= len(stack) || stack[i] != nil {
					stack = append(stack, cur.Right)
				} else {
					stack[i] = cur.Right
				}
				i++
			}
			cur = cur.Left
		}
		if cur.Right != nil {
			if i >= len(stack) || stack[i] != nil {
				stack = append(stack, cur.Right)
			} else {
				stack[i] = cur.Right
			}
			i++
		}
		result = append(result, cur.Val)
	}

	return result
}
