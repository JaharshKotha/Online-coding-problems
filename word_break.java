class Solution {
    
    static boolean check(String d,String s,int i)
    {
        if(d.length() > s.length()-i)
            return false;
        
        String t = s.substring(i,i+d.length());
       // System.out.println("in"+t+"/"+d+" /"+i+" "+d.length());
        if(t.equals(d))
            return true;
        else 
        return false;
    }
    public boolean wordBreak(String s, List<String> wordDict) {
        String res="";
        
        for(int i=0;i<s.length();i++)
        {
            
           
            char c = s.charAt(i);
            System.out.println(res+" "+i);
            for(String d: wordDict)
            {
                if(d.charAt(0) == c)
                {
                    
                    if(check(d,s,i))
                    {
                        
                        res+=s.substring(i,i+d.length());
                        i=i+d.length()-1;
                        
                        
                        break;
                    }
                    
                }
            }
            
        }
        //System.out.println(res+" "+s);
        if(res.equals(s))
            return true;
        else
            return false;
         
    }
}
