/*
 * Complete the function below.
 */
public  class Node{
    
    int val;
    Node left;
    Node right;
    Node(int x)
        {
        val = x;
    }
}

public static Node root = null;

    static void createBST(int[] keys) {
        int len = keys.length;
       
         if(root == null)
       { root = new Node() ;
        root.val = keys[0];
       }
        for(int i=1;i<len;i++)
            {
            insert(root,keys[i]);
            
        }
        
        return root;

    }

public static void insert(Node root, int x)
    {
    Node t = new Node(t);
    Node prev = root;
    while(root!=null)
        {
        prev = root;
        if(x > root.val)
            {
            root = root.right;
        }
        else
            {
            root = root.left;
        }
    }
    
    if(prev.val > x)
        {
        prev.left = t;
    }
    else
        {
        prev.right = t;
    }
} 

