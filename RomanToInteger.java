
import java.util.*;

public class Roman {

public static int romanToInt(String s) {
        
        HashMap<Character,Integer> h = new HashMap<Character,Integer>();
        h.put('I',1);
        h.put('V',5);
        h.put('X',10);
         h.put('L',50);
         h.put('C',100);
         h.put('D',500);
         h.put('M',1000);
        
        if(s.length()==1)
            return h.get(s.charAt(0));
        
        
        
      int res=0,t=0;
        boolean flg = true;
        
        res = h.get(s.charAt(s.length()-1));
        int x=s.length()-1;
        for(int i=s.length()-2;i>0;--i)
        {
            
            t=h.get(s.charAt(i));
            flg = (h.get(s.charAt(i))>=h.get(s.charAt(x))) ? true:false;
            if(flg)
                res+=t;
            else
                res-=t;

            --x;
        }
        
         t=h.get(s.charAt(0));
        flg = (h.get(s.charAt(0))>=h.get(s.charAt(1))) ? true:false;
            if(flg)
                res+=t;
            else
                res-=t;
        return res;
}
    

	public static void main(String[] args)
{
	
		System.out.println(romanToInt("MMMDXLIV"));
}

}
