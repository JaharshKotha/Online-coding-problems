public class Solution {
	public ArrayList<String> generateParenthesis(int a) {
	    StringBuilder parent = new StringBuilder("");
	    parent.insert(0,")");
	   for(int i=0;i<a-1;i++)
	  {
	      parent.append(")");
	  }
	   for(int i=0;i<a;i++)
	  {
	       parent.insert(0,"(");
	  }
	  
	  ArrayList<String> r = new ArrayList<String>();
	  r.add(parent.toString());
	  
	 //System.out.println(r);
	 for(int i=0;i<a;i++)
	 {
	     for(int j=a;j<((2*a)-1);j++)
	     {
	         StringBuilder temp = new StringBuilder(parent);
	         temp.deleteCharAt(i);
	         temp.insert(j,"(");
	        System.out.println(temp);
	         if(r.contains(temp.toString()))
	         {
	           
	         }
	         else
	         {
	               r.add(temp.toString());
	         }
	         
	     }
	     
	 }
	 
	 
// 	 for(int j=a;j<((2*a)-1);j++)
// 	 {
// 	     for(int i=0;i<a;i++)
// 	     {
// 	         StringBuilder temp = new StringBuilder(parent);
// 	         temp.deleteCharAt(j);
// 	         temp.insert(i,")");
// 	        System.out.println(temp);
// 	         if(r.contains(temp.toString()))
// 	         {
	           
// 	         }
// 	         else
// 	         {
// 	               r.add(temp.toString());
// 	         }
	         
// 	     }
	     
// 	 }
	 
	 
	 return r;
	  
	}
}
