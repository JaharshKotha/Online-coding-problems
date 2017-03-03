import java.io.*;
import java.util.*;
import java.text.*;
import java.math.*;
import java.util.regex.*;
import java.util.Scanner;


public class Solution {

    public static void main(String[] args) {
        
        Scanner sc = new Scanner(System.in);
        int a;
        int b;
        int k=0;
        a=sc.nexInt();
        b=sc.nexInt();
        
        ArrayList <Integer> ar = new ArrayList<Integer>();
        
        while(b>0)
            {
            --b;
            k= sc.nexInt();
            int t=0;
            
            for(int i=a;i<=b;i++)
                {
                t=ar.get(i);
                 ar.set(i,t+k);
                
            }
            
        }
        Collections.sort(ar);
        System.out.println(ar.get(0));
        
    }
}
