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
    public ArrayList<ArrayList<Integer>> verticalOrderTraversal(TreeNode a) {
        ArrayList<ArrayList<Integer>> r = new ArrayList<ArrayList<Integer>>(); 
       
        HashMap<Integer,ArrayList<Integer>>t = new HashMap<Integer,ArrayList<Integer>>();
  	    helper(a,t,0);
	    System.out.println(t);
	    SortedSet<Integer> keys = new TreeSet<Integer>(t.keySet());
            for (Integer key : keys) { 
               ArrayList<Integer> value = t.get(key);
             // System.out.println(value);
              //tem.add(value);
              r.add(value);
               
            }
	    return r;
    }
    
    public static void helper (TreeNode a ,HashMap<Integer,ArrayList<Integer>> t ,int l)
	    {
    	        if(a!=null)
    	    {
    	        helper(a.left,t,l-1);
    	        ArrayList<Integer> at = new ArrayList<Integer>();
    	        if(t.containsKey(l))
    	        {
    	           at = t.get(l);
    	           at.add(a.val);
    	           
    	           t.put(l,at);
    	        }
    	        else
    	        {
    	        at.add(a.val);
    	        
    	        t.put(l,at);
    	        }
    	       
    	        helper(a.right,t,l+1);
    	    }
	        
	    }
}
