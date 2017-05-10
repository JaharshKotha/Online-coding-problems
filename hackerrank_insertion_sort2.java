import java.io.*;
import java.util.*;

public class Solution {

    public static void insertionSortPart2(int[] ar,int s)
    {  
        
       for(int i=1;i<s;i++)
          {
          for(int j=0;j<i;j++)
              {
              if(ar[j]>ar[i])
                  {
                  int tem=ar[j];
                  int tem1;
                  ar[j]=ar[i];
             for(int z= j;z<i;z++)
                 {
                 tem1= ar[z+1];
                 ar[z+1]=tem;
                 tem=tem1;
                 
             }
              }
              
          }
           printArray(ar);
           
      }
        
        
    }  
    
    
      
    public static void main(String[] args) {
        Scanner in = new Scanner(System.in);
       int s = in.nextInt();
       int[] ar = new int[s];
       for(int i=0;i<s;i++){
            ar[i]=in.nextInt(); 
       }
        
       insertionSortPart2(ar,s);
        
                    
    }    
    private static void printArray(int[] ar) {
      for(int n: ar){
         System.out.print(n+" ");
      }
        System.out.println("");
   }
}
