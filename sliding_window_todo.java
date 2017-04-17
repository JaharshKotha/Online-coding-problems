import java.io.*;
import java.util.*;
import java.text.*;
import java.math.*;
import java.util.regex.*;
import java.util.HashMap;

public class Solution {

    public static void main(String[] args) {
        /* Enter your code here. Read input from STDIN. Print output to STDOUT. Your class should be named Solution. */
        Scanner s = new Scanner(System.in);
        int n = s.nextInt();
        int a[] = new int [n];
        HashMap h = new HashMap();
        for(int i=0;i<n;i++)
            {
            a[i] = sc.nextInt();
            h.put(a[i],i);
        }
        
        Arrays.sort(a);
        
        int d[] = new int[n];
        
        for(int i=1;i<n;i++)
            {
            d[i-1] = d[i]-d[i-1];
        }
        int min = Integer.MAX_VALUE;
        for(int k=0;k<n;k++)
            {
            if(min > d[k])
                {
                min = k;
            }
        }
        
        if()
            {
            
        }
        
    }
}
