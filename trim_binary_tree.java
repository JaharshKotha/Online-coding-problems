class Solution {
//Keeps track of all the permitted values
    public static ArrayList<Integer> al = new ArrayList<Integer>();
    
    public TreeNode trimBST(TreeNode root, int L, int R) {
        al = new ArrayList<Integer>();
        if(root == null)
            return null;
        populate(root,L,R);
        if(al.size()==0)
            return null;
        TreeNode rt = new TreeNode(al.get(0));
        for(int i=1;i<al.size();i++)
            rt = insert(rt,al.get(i));
        
        return rt;
        
    }
    // Populates the array list with permitted values ; We do an preorder traversal to maintain the order of the elements in the tree

    static void populate(TreeNode root, int L, int R)
    {
        if(root == null)
            return;
        if(root.val >= L && root.val <=R )
            al.add(root.val);
        populate(root.left,L,R);
        populate(root.right,L,R);
        
        
        
    }
    
//creates a new tree by inserting the values one by one
    static TreeNode insert(TreeNode rt ,int n)
    {
        if(rt == null)
            return new TreeNode(n);
        
        if(n>rt.val)
        {
            rt.right=insert(rt.right,n);
        }
        else
            rt.left=insert(rt.left,n);
        
        return rt;
    }
    
}
