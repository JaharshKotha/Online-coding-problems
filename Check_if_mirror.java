/**
 * Definition for a binary tree node.
 * public class TreeNode {
 *     int val;
 *     TreeNode left;
 *     TreeNode right;
 *     TreeNode(int x) { val = x; }
 * }
 */
public class Solution {
    static int flag =0;
    public   ArrayList<Integer> a = new ArrayList<Integer>();
       ArrayList<Integer> b=  new ArrayList<Integer>();
    public boolean isSymmetric(TreeNode root) {
        if(root==null)
        return true;
        
       TreeNode l =root;
       TreeNode r = root;
       
      
        checkl(l);
        checkr(r);
        System.out.println(a);
        System.out.println(b);
        
        if(a.equals(b))
        {return true;}
        else
        return false;
        
        
        
    }
    
    public void checkl(TreeNode root)
    {
       
        if(root==null)
        {
            return;
        }
        
        checkl(root.left);
        a.add(root.val);
        checkl(root.right);
        
        
    }
    public void checkr(TreeNode root)
    {
       
        if(root==null)
        {
            return;
        }
        
        checkr(root.right);
        b.add(root.val);
        checkr(root.left);
        
        
    }
    
    
    
}
