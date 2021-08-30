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

	result = append(result, root.Val)
	if root.Left != nil {
		r := preorderTraversal(root.Left)
		for _, v := range r {
			result = append(result, v)
		}

	}
	if root.Right != nil {
		r := preorderTraversal(root.Right)
		for _, v := range r {
			result = append(result, v)
		}
	}

	return result
}
