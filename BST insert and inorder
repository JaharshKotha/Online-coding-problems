public class Bst{

    public class Node
    {
        int data;
        Node left,right;
        
        Node(int dat)
        {
            this.data=dat;
            left=right=null;
        }
    }
    
    Node root;
    
    Bst()
    {
        root=null;
    }
    
    void insert(int dat)
    {
        if(this.root==null)
        {
           // System.out.println("inside");
            this.root=new Node(dat);
            return;
        }
        Node m=this.root;
        Node z=m;
        int cnt=1;
        while(m != null )
        {
            z=m;
        
            if(m.data < dat)
            {
                
                m=m.right;
                cnt =1;
            }
            else if (m.data > dat)
            {
                m=m.left;
                cnt =2;
            }
            
        }
       
       if(cnt ==1 )
       {
           z.right = new Node(dat);
       }
       else
       {
           z.left = new Node(dat);
       }
        
        return;
    }
    
    void inorder(Node root)
    {
        if(root!=null)
        {
            inorder(root.left);
            System.out.println(root.data);
            inorder(root.right);
        }
            
        }
        
    
     public static void main(String []args){
    
    Bst list = new Bst();
    
    list.insert(50);
        list.insert(30);
        list.insert(20);
        list.insert(40);
        list.insert(70);
        list.insert(60);
        list.insert(80);
 
        // print inorder traversal of the BST
        list.inorder(list.root);
    
    
     }
}
