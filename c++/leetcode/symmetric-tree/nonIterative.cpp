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
        vector<pair<TreeNode*, TreeNode*>> stack;
        pair<TreeNode*, TreeNode*> levelNodes;

        if (!root) {
            return true;
        }
        if (!root->left && !root->right) {
            return true;
        }
        if (!root->left && root->right || !root->right && root->left) {
            return false;
        }

        stack.push_back({root->left, root->right});
        while (!stack.empty()) {
            levelNodes = stack.back();
            TreeNode* left = levelNodes.first;
            TreeNode* right = levelNodes.second;
            stack.pop_back();

            if (left && !right || !left && right) {
                return false;
            }

            if (left && right) {
                if (left->val != right->val) {
                    return false;
                }

                stack.push_back({left->left, right->right});
                stack.push_back({left->right, right->left});
            }
        }

        return true;
    }
};
