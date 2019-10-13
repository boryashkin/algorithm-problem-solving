/**
 * https://leetcode.com/problems/path-sum/
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
    bool hasPathSum(TreeNode* root, int sum) {
        int res;
        if (!root) {
            return false;
        }
        res = dfsFindSum(root, sum);
        cout << res;
        return res == 0;
    }
    int dfsFindSum(TreeNode* node, int sum) {
        int lSum = 0;
        int rSum = 0;
        bool r = false, l = false;
        if (!node) {
            return 0;
        }
        if (!node->left && !node->right) {
            return sum - node->val;
        }

        sum -= node->val;

        if (node->left) {
            l = true;
            lSum = dfsFindSum(node->left, sum);
        }
        if (node->right) {
            r = true;
            rSum = dfsFindSum(node->right, sum);
        }

        if (l && !r) {
            return lSum;
        } else if (r && !l) {
            return rSum;
        }

        return (abs(lSum) < abs(rSum)) ? lSum : rSum;
    }
};