public class Linkedl{
    //Linked list implemetation
    class Node
    {
        int data;
        Node next;
        
        Node(int dat)
        {
            data=dat;
            next=null;
        }
    }
    
    Node head;
    Linkedl()
    {
        head=null;
        
    }
    
    public void insertbeg(int dat)
    {
        if(head==null)
        {
            this.head= new Node(dat);
            return ;
        }
        
     Node pt=new Node(dat);
     pt.next=head;
     head=pt;
     
     //return 0;
    }
    
    public void insertafter(int pos,int dat)
    {
        
        Node x=this.head;
        for(int i=0;i<pos-1;i++)
        {
           
            x=x.next;
            
             if(x==null)
            {
                System.out.println("Sorry beyond the linked list");
                return;
            }
        }
        
       // System.out.println("this is x "+x.data);
        Node z=x.next;
        
        Node y=new Node(dat);
        
        x.next=y;
        y.next=z;
        
        
    }
    
    public void insertbef(int pos,int dat)
    {
        Node f= new Node(dat);
        Node d,e;
        if(pos==1)
        {
            f.next=head;
            head=f;
            return;
        }
        e=d=this.head;
        
        for(int i=0;i<pos-1;i++)
        {
            d=e;
            e=e.next;
            
        }
        
        d.next=f;
        f.next=e;
        
        return;
        
        
        
    }
    
    public void plist()
    {
        Node te = this.head;
        while(te!=null)
        {
            System.out.println(te.data);
            te=te.next;
        }
        
    }
    
     public static void main(String []args){
    
    Linkedl list= new Linkedl();
    
    list.insertbeg(22);
    list.insertbeg(32);
     list.insertbeg(42);
      list.insertbeg(52);
      list.insertafter(3,30);
      list.insertbef(1,29);
    list.plist();
    
         
     }
}

    
