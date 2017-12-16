//https://www.hackerrank.com/contests/world-codesprint-12/challenges/red-knights-shortest-path

import java.io.*;
import java.util.*;
import java.text.*;
import java.math.*;
import java.util.regex.*;

public class Solution {
    
   
    public static class pos
    {
        int x;
        int y;
        pos(int x,int y)
        {
            this.x = x;
            this.y =y;
        }
    }
    static boolean check(int i_start, int j_start, int i_end, int j_end,int r,int c)
    {
        if(r<i_start || c<j_start ||r>i_end||c>j_end)
            return true;
        else
            return false;
    }
    
    static ArrayList<pos> populate(int i_start,int j_start,int i_end,int j_end)
    {
        ArrayList<pos> tem = new ArrayList<pos>();
      if(check(i_start,j_start,i_end,j_end,i_start-2,j_start-1))
        {
            pos p = new pos(i_start-2,j_start-1);
           tem.add(p); 
        }
        if(check(i_start,j_start,i_end,j_end,i_start-2,j_start+1))
        {
            pos p = new pos(i_start-2,j_start+1);
           tem.add(p); 
        }
        if(check(i_start,j_start,i_end,j_end,i_start+2,j_start-1))
        {
            pos p = new pos(i_start-2,j_start+1);
           tem.add(p); 
        }
        if(check(i_start,j_start,i_end,j_end,i_start+2,j_start+1))
        {
            pos p = new pos(i_start+2,j_start+1);
           tem.add(p); 
        }
        if(check(i_start,j_start,i_end,j_end,i_start,j_start-2))
        {
            pos p = new pos(i_start,j_start-2);
           tem.add(p); 
        }
        if(check(i_start,j_start,i_end,j_end,i_start,j_start+2))
        {
            pos p = new pos(i_start,j_start+2);
           tem.add(p); 
        }
        
        return tem;
    }
    static void printShortestPath(int n, int i_start, int j_start, int i_end, int j_end) {
        //  Print the distance along with the sequence of moves.
        Queue<ArrayList<pos>> q = new LinkedList<ArrayList<pos>>();
        pos p = new pos(i_start,j_start);
        ArrayList<pos> tem= new ArrayList<pos>();
        tem.add(p);
        ArrayList<ArrayList<pos>> result = new ArrayList<ArrayList<pos>>();
        q.add(tem);
        int min =10000,flg=0;
        while(!q.isEmpty())
        {
            ArrayList<pos> path = q.remove();
            pos cur = path.get(path.size()-1);
            ArrayList<pos> temp = populate(cur.x,cur.y,i_end,j_end);
            
            for(int i=0;i<tem.size();i++)
        {
         ArrayList<pos> next = new ArrayList<pos>(path); 
         next.add(temp.get(i));
         System.out.println(next);       
          if(flg==1 && next.size()>min)
              continue;
         if(temp.get(i).x == i_end && temp.get(i).y==j_end)
         {
             if(min>next.size())
             {
                 flg=1;
                min =  next.size();
                result.add(next);
             }
             
             
         }
                else
                {
                 q.add(next);   
                }               
                
        }
        }
        if(result.size()==0)
          System.out.println("Impossible");
        else
            System.out.println(result);
        
         
    }
    

    public static void main(String[] args) {
        Scanner in = new Scanner(System.in);
        int n = in.nextInt();
        int i_start = in.nextInt();
        int j_start = in.nextInt();
        int i_end = in.nextInt();
        int j_end = in.nextInt();
        printShortestPath(n, i_start, j_start, i_end, j_end);
        in.close();
    }
}
