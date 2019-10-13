/**
 * https://leetcode.com/problems/symmetric-tree/
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
    bool isSymmetric(TreeNode* root) {
        if (!root) {
            return true;
        }
        if (root->left && root->right) {
            return compareNodes(root->left, root->right);
        } else if (!root->left && !root->right) {
            return true;
        }

        return false;
    }
    bool compareNodes(TreeNode* left, TreeNode* right) {
        if (!left && !right) {
            return true;
        } else if (left && !right || !left && right) {
            return false;
        }

        return left->val == right->val && compareNodes(left->left, right->right) && compareNodes(left->right, right->left);
    }
};
