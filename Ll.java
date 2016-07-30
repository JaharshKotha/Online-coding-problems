package summer;

public class Ll {
	
	Node head;
	
	public void insert(int x, int dat)
	{
		Node a=new Node(dat);
		Node n=head;
		Node b;
		b=n;
		for(int i=0;i<x-1;i++)
		{
			b=n;
			n=n.next;
		}
		b.next=a;
	
	a.next=n;
	return;
	
	
	}
	public void append(int dat)
	{
	
		Node n= new Node(dat);
		
		if(head == null)
		{
			head = new Node(dat);
			head.next=null;
			return;
		}
		
		n.next=null;
		
		Node temp=head;
		
		while(temp.next!=null)
		{
			temp=temp.next;
			
		}
		
		temp.next=n;
		
			
		
		
	}
	void printar()
	{
		Node t=head;
		while(t.next!=null)
		{
			System.out.println(t.data);
			t=t.next;
		}
		System.out.println(t.data);
	}
	
	class Node 
	{
		int data;
		Node next;
		Node(int dat)
		{
			this.data=dat;
			this.next=null;
		}
	}

	public static void main(String args[])
	{
Ll l= new Ll();
l.append(2);
l.append(33);
l.append(5);
l.append(6);
//l.append(88);
l.insert(1, 40);

l.printar();

		
}
}
