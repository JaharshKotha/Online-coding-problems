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
    public List<List<Integer>> levelOrder(TreeNode root) {
        	    Queue<TreeNode> q = new LinkedList<TreeNode>();
	    List<List<Integer>> r = new ArrayList<List<Integer>>();
	   if(root ==null)
           return r;
	    q.add(root);
	    int s =1;
	    ArrayList<Integer> t = new ArrayList<Integer>();
	    while(!q.isEmpty()){
	       
	        if(s==0)
	        {
	           // System.out.println("t");
	            System.out.println(t);
                ArrayList<Integer> o = new ArrayList<Integer>(t);
	            r.add(o);
	        t.clear();
	        s=q.size();
	        }
	        TreeNode te = q.poll();
	        
	        t.add(te.val);
	       
	        if(te.left != null)
	        q.add(te.left);
	        if(te.right != null)
	        q.add(te.right);
	        
	        --s;
	        
	    }
         ArrayList<Integer> o = new ArrayList<Integer>(t);
	            r.add(o);
	    return r;
        
    }
}
