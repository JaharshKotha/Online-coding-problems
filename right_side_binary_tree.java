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
    public List<Integer> rightSideView(TreeNode root) {
        Queue<TreeNode> q =new LinkedList<TreeNode>();
         q.add(null);
        q.add(root);
       
        
        List<Integer> res = new ArrayList<Integer>();
        while(!q.isEmpty())
        {
            if(q.peek()==null)
            {
                
                 q.remove();
                TreeNode cur = q.poll();
                if(cur==null)
                    continue;
                res.add(cur.val); 
                q.add(null);
               if(cur.right!=null) 
            q.add(cur.right);
                if(cur.left!=null)
                q.add(cur.left);
                
                continue;
            }
            //System.out.println(res);
            TreeNode cur = q.poll();
            if(cur.right!=null)
            q.add(cur.right);
            if(cur.left!=null)
            q.add(cur.left);
            
        }
        return res;
        
    }
}
