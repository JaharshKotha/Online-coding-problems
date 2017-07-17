
public class Solution {
    
    public static int gh(TreeNode root)
    {
    if(root==null)
        return -1;
        
        return Math.max(gh(root.left)+1,gh(root.right)+1);
        
    }
    
    public boolean isBalanced(TreeNode root) {
        if(root == null)
        {
            return true;
        }
        int h= gh(root.left) - gh(root.right);
        if(Math.abs(h)>1)
        { return false; }
        else
        { return isBalanced(root.left) && isBalanced(root.right);}
        
    }
}
