import java.io.*;
import java.util.*;
import java.text.*;
import java.math.*;
import java.util.regex.*;

public class Solution {
    
    public static class obj
    {
        int l;
        ArrayList<String> r = new ArrayList<String>();
    }

    static void printShortestPath(int n, int i_start, int j_start, int i_end, int j_end) {
        //  Print the distance along with the sequence of moves.
        
    }
    static void h(int n, int i_start, int j_start, int i_end, int j_end,int r,int c,int f)
    {
        if(r<i_start || c<j_start ||r>i_end||c>j_end)
            return 0;
        switch(flg)
        {
            case 1:{}
        }
        if(r==i_end && c==j+end)
        {
            
           return 1; 
        }
            
        
        int s = Math.min(h(n,i_start,j_start,r-2,c-1,i_end,j_end,1),
                         h(n,i_start,j_start,r-2,c+1,i_end,j_end,2),
                         h(n,i_start,j_start,r+2,c-1,i_end,j_end,3),
                         h(n,i_start,j_start,r+2,c+1,i_end,j_end,4),
                         h(n,i_start,j_start,r,c-2,i_end,j_end,5),
                         h(n,i_start,j_start,r,c+2,i_end,j_end),6);
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
