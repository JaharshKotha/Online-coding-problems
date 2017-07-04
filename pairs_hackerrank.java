import java.io.*;
import java.util.*;
import java.text.*;
import java.math.*;
import java.util.regex.*;

public class Solution {
    static int pairs(int[] a,int k) {
        if(a.length == 0)
            return 0;
        int res=0;
        HashMap<Integer,Boolean> hm = new HashMap<Integer,Boolean>();
        HashMap<String,Boolean> ch = new HashMap<String,Boolean>();
        for(int i=0;i<a.length;i++)
        {
             hm.put(a[i],true);
            
        }
        for(int i=0;i<a.length;i++)
        {
            
             
            if(hm.containsKey(Math.abs(a[i]-k)) && a[i]!=Math.abs(a[i]-k) )
            {
                String val = Integer.toString(a[i])+","+Integer.toString(a[i]-k);
                String val1 = Integer.toString(a[i]-k)+","+Integer.toString(a[i]);
                //System.out.println(val1+val);
                if(ch.containsKey(val) || ch.containsKey(val1))
                {
                    continue;
                }
                else
                {
                    ch.put(val,true);
                    ch.put(val1,true);
                     ++res;
                }
               // hm.remove(a[i]);
               
            }
        }
       
        return res;
        //return 0;
    }

    public static void main(String[] args) {
        Scanner in = new Scanner(System.in);
        int res;
        
        String n = in.nextLine();
        String[] n_split = n.split(" ");
        
        int _a_size = Integer.parseInt(n_split[0]);
        int _k = Integer.parseInt(n_split[1]);
        
        int[] _a = new int[_a_size];
        int _a_item;
        String next = in.nextLine();
        String[] next_split = next.split(" ");
        
        for(int _a_i = 0; _a_i < _a_size; _a_i++) {
            _a_item = Integer.parseInt(next_split[_a_i]);
            _a[_a_i] = _a_item;
        }
        
        res = pairs(_a,_k);
        System.out.println(res);
    }
}
