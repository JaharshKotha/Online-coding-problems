/**
 * Definition for singly-linked list.
 * public class ListNode {
 *     int val;
 *     ListNode next;
 *     ListNode(int x) { val = x; }
 * }
 */
public class Solution {
    public static ListNode reverseLinkedList(ListNode currentNode)  
	 {  
	// For first node, previousNode will be null  
		 ListNode previousNode=null;  
		 ListNode nextNode;  
	  while(currentNode!=null)  
	  {  
	   nextNode=currentNode.next;  
	  // reversing the link  
	   currentNode.next=previousNode;  
	  // moving currentNode and previousNode by 1 node  
	   previousNode=currentNode;  
	   currentNode=nextNode;  
	  }  
	  return previousNode;  
	 }  

	//Read more at http://www.java2blog.com/2014/07/how-to-reverse-linked-list-in-java.html#1ykgFLssmPMU7pXe.99
	public static ListNode addTwoNumbers(ListNode l1, ListNode l2) {
        double x=1,y=1;
        double num1=0,num2=0,sum=0;
        ListNode l3=l1;
        ListNode l4=l2;
        while(l1!=null)
        {
        	//System.out.println("this="+(l1.val*x)+"  l1"+l1.val +"  x="+x);
        	 //System.out.print(l1.val);
        	 num1=num1+(l1.val*x);
        	// System.out.println(num1);
             x=x*10;
             
             
            l1=l1.next;
           
        }
        x=x/10;
       
        while(l2!=null)
        { System.out.println(l2.val*y);
        	 num2=num2+(l2.val*y);
             y=y*10;
             
            l2=l2.next;
        }
        y=y/10;
        
      
       // System.out.println("num1  "+num1);
        
        
        sum=num1+num2;
        System.out.println("");
        System.out.println("num1");
        System.out.printf("%f",num1);
        System.out.println("num2");
         System.out.printf("%f",num2);
         System.out.println("sum");
        System.out.printf("%f",sum);
      double cu=sum%10;  
       System.out.println("this"+cu);
        ListNode root=new ListNode((int)cu);
        sum=sum/10;
        ListNode l5=root;
       
        while(sum >= 1)
        {
            System.out.println("");
              System.out.printf("%f",sum);
              
        	
            ListNode l=new ListNode((int)sum%10);
            sum=sum/10;
            l5.next=l;
            l5=l;
            
        }
        
       return root;
        
        
    }
}
