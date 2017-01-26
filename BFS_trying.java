import java.io.*;
import java.util.*;
import java.text.*;
import java.math.*;
import java.util.regex.*;

public class Solution {

    public static void main(String[] args) {
      Scanner sc= new Scanner(System.in);
        int t=sc.nextInt();
        int n=0,e=0,s=0,temp=0,dist=0;
        while(t>0)
            {
            n=0;e=0;
            n= sc.nextInt();
            e=sc.nextInt();
            
            int m [][] = new int [n][n];
            boolean visit[] = new boolean[n];
            for(int i=0;i<n;i++)
                {
               visit[i] = false;
            }
            for(int i=0;i<n;i++)
                {
                int t1=sc.nextInt()-1;
                int t2=sc.nextInt()-1;
                
                m[t1][t2] = 1;
                  m[t2][t1] = 1;
                
            }
            
            s=sc.nextInt();
            Queue <Integer> q=new LinkedList<Integer> ();
            int[] h= new  int[n]; 
              for(int i=0;i<n;i++)
                {
                h[i] = -1;
                
            }
            s=s-1;
            q.add(s);
            int cnt=0;
            while(!q.isEmpty())
                {
                temp =q.remove();
                visit[temp]=true;
                h[temp] = dist;
               
                    dist = dist +6;
                for(int i=0;i<n;i++)
                    {
                    if(m[temp][i]==1 && visit[temp]==false)
                        {
                        q.add(i);
                        
                        ++cnt;
                    }
                }
                --cnt;
            }
            
            for(int i=0;i<n;i++)
                {
               System.out.print(h[i]+" ");
            }
            --t;
            System.out.println();
        }
        
    }
}
