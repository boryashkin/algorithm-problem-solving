/**
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
    vector<int> vec;
    vector<int> preorderTraversal(TreeNode* root) {
        dfs(root, &vec);

        return vec;
    }
    void dfs(TreeNode* node, vector<int>* vec) {
        if (!node) {
            return;
        }
        if (node->left) {
            dfs(node->left, vec);
        }
        vec->push_back(node->val);
        if (node->right) {
            dfs(node->right, vec);
        }
    }
};