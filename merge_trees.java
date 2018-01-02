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
    public TreeNode mergeTrees(TreeNode t1, TreeNode t2) {
        ArrayList<String> re = new ArrayList<String>();
        TreeNode r = new TreeNode(t1.val+t2.val);
        help(t1,t2,r,re);
       
        for(int i=0;i<re.size()-1;i++)
        {
            if(re.get(i)=="null" && re.get(i+1)="null")
            {re.remove(i);re.remove(i+1);}
                
        }
        
        return r;
        
    }
    
    static void help(TreeNode t1, TreeNode t2 ,TreeNode r,ArrayList<String>re)
    {
        if(t1 ==null && t2==null)
        {
            re.add("null");
            return;
        }
        int v1=0,v2=0;
        if(t1 !=null)
          v1 = t1.val;

        if(t2!=null)
            v2 = t2.val;
        
        
        r =new TreeNode(v1+v2);
        int tem = v1+v2;
        re.add(String.valueOf(tem));
        
        
        if(t1==null)
            help(t1,t2.left,r.left,re);
        else if(t2==null)
            help(t1.left,t2,r.left,re);
        else 
        help(t1.left,t2.left,r.left,re);
        
        if(t1==null)
            help(t1,t2.right,r.right,re);
        else if(t2==null)
            help(t1.right,t2,r.right,re);
        else 
        help(t1.right,t2.right,r.right,re);
        
    }
}
