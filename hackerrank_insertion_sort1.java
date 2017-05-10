import java.io.*;
import java.util.*;
import java.text.*;
import java.math.*;
import java.util.regex.*;

public class Solution {
    
    

    public static void insertIntoSorted(int[] ar,int s,int c) {
        if(s==0)
            return ;
        int tp = s-1;
        for(int i=s-2;i>=0;--i)
            {
            if(ar[i] > c)
                {
                ar[tp] = ar[i];
                printArray(ar);
                --tp;
            }
            else
                {
                ar[tp]=c;
                printArray(ar);
                return;
            }
        }
        
        ar[0]=c;
          printArray(ar);
       
        
    }
    
    
/* Tail starts here */
    public static void main(String[] args) {
        Scanner in = new Scanner(System.in);
        int s = in.nextInt();
        int[] ar = new int[s];
        for(int i=0;i<s;i++){
            ar[i]=in.nextInt(); 
        }
        int c= ar[s-1];
        insertIntoSorted(ar,s,c);
    }
    
    
    private static void printArray(int[] ar) {
        for(int n: ar){
            System.out.print(n+" ");
        }
        System.out.println("");
    }
}
 
