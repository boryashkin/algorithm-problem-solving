/**
 * https://leetcode.com/problems/maximum-depth-of-binary-tree/
 *
 * Definition for a binary tree node.
 * struct TreeNode {
 *     int val;
 *     TreeNode *left;
 *     TreeNode *right;
 *     TreeNode(int x) : val(x), left(NULL), right(NULL) {}
 * };
 */
class Solution {
public:
    int maxDepth(TreeNode* root) {
        return dfsMaxDepth(root);
    }
    int dfsMaxDepth(TreeNode* node) {
        int lRes = 0;
        int rRes = 0;
        if (!node) {
            return 0;
        }
        if (!node->left && !node->right) {
            return 1;
        }
        if (node->left) {
            lRes = dfsMaxDepth(node->left);
        }
        if (node->right) {
            rRes = dfsMaxDepth(node->right);
        }

        return max(lRes, rRes) + 1;
    }
};
