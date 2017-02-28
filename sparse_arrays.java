import java.io.*;
import java.util.*;
import java.text.*;
import java.math.*;
import java.util.regex.*;

public class Solution {

    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        int n = sc.nextInt();
        sc.nextLine();
        ArrayList<String> c = new ArrayList<String>();
        
        for(int i=0;i<n;i++)
            {
            String t =sc.nextLine();
            c.add(t);
            
        }
         int q = Integer.parseInt(sc.nextLine());
        int cnt =0;
        while(q>0)
            {
            String t= sc.nextLine();
            for(int i=0;i<c.size();i++)
            {
                
            if(t.equals(c.get(i)))
                {++cnt;}
            
        }
            System.out.println(cnt);
        cnt=0;
            --q;
        }
       
    }
}
