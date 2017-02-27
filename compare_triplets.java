import java.io.*;
import java.util.*;
import java.text.*;
import java.math.*;
import java.util.regex.*;

public class Solution {

    public static void main(String[] args) {
        Scanner in = new Scanner(System.in);
        int a0 = in.nextInt();
        int a1 = in.nextInt();
        int a2 = in.nextInt();
        int b0 = in.nextInt();
        int b1 = in.nextInt();
        int b2 = in.nextInt();
        
        int a[] = new int [3];
        int b[] = new int [3];
        int i=0,j=0;
        if(a0>b0)
            {
            a[i]=1;
            ++i;
        }
        else if(a0<b0)
            {
            b[j]=1;
            ++j;
        }
        else
            {
            
        }
        
        if(a1>b1)
            {
            a[i]=1;
            ++i;
        }
        else if(a1<b1)
            {
            b[j]=1;
            ++j;
        }
        else
            {
            
        }
        if(a2>b2)
            {
            a[i]=1;
            ++i;
        }
        else if(a2<b2)
            {
            b[j]=1;
            ++j;
        }
        else
            {
            
        }
        
        int sum=0;
        
        for(int x=0;x<i;x++)
            {
         sum+=a[x]; 
        }
         System.out.print(sum);
         System.out.print(" ");
        sum=0;
        for(int x=0;x<j;x++)
            {
            sum+=b[x];
        }
          System.out.print(sum);
        
        
        
    }
}
