/**
 * Definition for binary tree
 * class TreeNode {
 *     int val;
 *     TreeNode left;
 *     TreeNode right;
 *     TreeNode(int x) { val = x; }
 * }
 */
public class Solution {
	public int maxDepth(TreeNode a) {
	    if(a == null)
	    {
	        return 0;
	    }
	    int m[] = new int[1];
	    helper(a,m,0);
	    int r = m[0];
	    return ++r;
	}
	
	public static void helper (TreeNode a ,int m[],int l)
	    {
    	        if(a!=null)
    	    {
    	        helper(a.left,m,l+1);
    	        if(m[0] < l)
    	        {
    	       m[0]= l;
    	        }
    	        helper(a.right,m,l+1);
    	    }
	        
	    }
}
