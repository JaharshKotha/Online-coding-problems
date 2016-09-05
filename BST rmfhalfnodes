package summer;

public class BST_deletion{

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
    
    BST_deletion()
    {
        root=null;
    }
    
  public  void insert(int dat)
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
    
  public  void inorder(Node root)
    {
        if(root!=null)
        {
            inorder(root.left);
            System.out.println(root.data);
            inorder(root.right);
        }
            
        }
        
   public void delete(int tar)
    {
    	Node x=root;
    	Node prev=null;
    	
    	while(x!=null)
    	{
    		if(x.data==tar)
    			break;
    		else if(x.data < tar)
    		{
    			prev=x;
    			x=x.right;
    		}
    		else
    		{
    			prev=x;
    			x=x.left;
    		}
    	}
    	
    	if(x==null)
    	{System.out.print("Sorry the value not found in tree");}
    	
    	
    	if(x.left==null && x.right==null)
    	{
    		if(prev.right==x)
    			{prev.right=null; return;}
    		else
    			{prev.left=null; return;}
    	}
    	else if (x.left==null && x.right!=null)
    	{
    		Node t = x;
    		t=t.right;
    		x.data=t.data;
    		x.right=null;
    		return;
    		
    	}
    	
    	else if(x.left!=null && x.right==null)
    	{
    		Node t = x;
    		t=t.left;
    		x.data=t.data;
    		x.left=null;
    		return;
    		
    	}
    	else
    	{
    		Node t= x,tem=null;
    		t=x.left;
    		while(t!=null)
    		{
    			tem=t;
    			t=t.right;
    		}
    		
    		x.data=tem.data;
    		
    		Node t1=x,tem1=t1;
    		
    			
    		t1=x.left;
    		
    		while(t1.data!=x.data)
    		{
    			tem1=t1;
    			t1=t1.right;
    			
    		}
    		
    		
    		if(tem1.left==t1)
    		{
    			tem1.left=null;
    			return;
    		}
    		else
    		{
    			tem1.right=null;
    			return;
    		}
    		
    		
    	}
    	
    	
    }
   
   
   public void remhfnodes(Node n)
   {
	   if(n!=null)
	   {
		   remhfnodes(n.left);
		   if((n.left==null&&n.right!=null))
		   {
			   delete(n.data);
		   }
		   if((n.left!=null&&n.right==null))
		   {
			   delete(n.data);
		   }
		   remhfnodes(n.right);
	   }
   }
    
    
     public static void main(String []args){
    
    	 BST_deletion list = new BST_deletion();
    
    list.insert(12);
        list.insert(11);
        list.insert(27);
        list.insert(20);
        list.insert(30);
        list.insert(60);
        list.insert(80);
 
        // print inorder traversal of the BST
        list.inorder(list.root);
        
        list.remhfnodes(list.root);
        System.out.print("AFter :");
        list.inorder(list.root);
    
    
     }
}
