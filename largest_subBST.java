/**
 * Definition for a binary tree node.
 * public class TreeNode {
 *     int val;
 *     TreeNode left;
 *     TreeNode right;
 *     TreeNode(int x) { val = x; }
 * }
 */
class Solution {
    public int largestBSTSubtree(TreeNode root) {
        if(root ==null)
            return 0;
        if(root.left==null && root.right==null)
            return 1;
        
        
        return helper(root);
        
        
    }
    static int helper(TreeNode root)
    {
        
        if(root == null)
            return 0;
        
        int flg=0;
        
        if(root.right!=null)
        {
            if(!(root.val<root.right.val))
            {
                flg=1;
            }
        }
        if(root.left!=null)
        {
            if(!(root.val>root.left.val))
            {
                flg=1;
            }
        }
        
        if(flg == 0)
        {
            //System.out.println("IN"+ root.val+" "+((helper(root.left))+(helper(root.right))+1));
            return ((helper(root.left))+(helper(root.right))+1);
        }
            
        else
        {
           // System.out.println(root.val+" "+Math.max(helper(root.left),helper(root.right)));
            return Math.max(helper(root.left),helper(root.right));
        }
            
    }
}
