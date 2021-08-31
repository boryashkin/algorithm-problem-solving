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

	if root == nil {
		return result
	}

	if root.Left != nil {
		for _, v := range inorderTraversal(root.Left) {
			result = append(result, v)
		}
	}
	result = append(result, root.Val)
	if root.Right != nil {
		for _, v := range inorderTraversal(root.Right) {
			result = append(result, v)
		}
	}

	return result
}
