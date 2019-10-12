/**
 * https://leetcode.com/problems/binary-tree-level-order-traversal/
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
    vector<vector<int>> vec;
    vector<vector<int>> levelOrder(TreeNode* root) {
        vector<TreeNode*> queue;
        TreeNode* node;
        int currentLevelCnt = 0;
        int nextLevelCnt = 0;

        queue.push_back(root);

        currentLevelCnt++;
        while (!queue.empty()) {
            node = queue.front();
            queue.erase(queue.begin());
            if (!node) {
                continue;
            }
            if (--currentLevelCnt <= 0) {
                currentLevelCnt = nextLevelCnt;
                nextLevelCnt = 0;
                vector<int> vecItem;
                vec.push_back(vecItem);
            }
            vec.back().push_back(node->val);

            if (node->left) {
                nextLevelCnt++;
                queue.push_back(node->left);
            }
            if (node->right) {
                nextLevelCnt++;
                queue.push_back(node->right);
            }
        }

        return vec;
    }
};