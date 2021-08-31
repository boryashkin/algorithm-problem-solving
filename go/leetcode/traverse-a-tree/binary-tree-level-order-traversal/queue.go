package binary_tree_level_order_traversal

/**
 * Definition for a binary tree node.
 * type TreeNode struct {
 *     Val int
 *     Left *TreeNode
 *     Right *TreeNode
 * }
 */
func levelOrder(root *TreeNode) [][]int {
	result := make([][]int, 0)
	queue := make([]*TreeNode, 0)

	queue = append(queue, root)
	nextLvlLen := 0
	curLvlLen := 1
	lvl := 0
	for i := 0; i < len(queue); i++ {
		if queue[i] == nil {
			break
		}

		if len(result) < lvl+1 {
			v := []int{}
			result = append(result, v)
		}
		result[lvl] = append(result[lvl], queue[i].Val)

		if queue[i].Left != nil {
			queue = append(queue, queue[i].Left)
			nextLvlLen++
		}
		if queue[i].Right != nil {
			queue = append(queue, queue[i].Right)
			nextLvlLen++
		}

		curLvlLen--
		if curLvlLen <= 0 {
			curLvlLen = nextLvlLen
			nextLvlLen = 0
			lvl++
		}
	}

	return result
}
