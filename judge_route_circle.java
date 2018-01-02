class Solution {
    public boolean judgeCircle(String moves) {
        String r="";
        char[] ca=moves.toCharArray();  
        
        for(char c: ca)
        {
            if(c=='U')
                r+="D";
            if(c=='D')
            {
                int p = r.indexOf('D');
                if(p==0)
                {
                    r=r.substring(1,r.length()-1);
                    continue;
                }
                if(p==r.length()-1)
                {
                    r = r.substring(0,r.length()-2);
                    continue;
                }
                r = r.substring(0,p-1)+r.substring(p+1,r.length());
                
            }
            
            if(c=='R')
                r+="L";
            
           if(c=='L')
            {
                int p = r.indexOf('L');
               if(p==0)
                {
                    r=r.substring(1,r.length()-1);
                    continue;
                }
                if(p==r.length()-1)
                {
                    r = r.substring(0,r.length()-2);
                    continue;
                }
                r = r.substring(0,p-1)+r.substring(p+1,r.length());
                
            } 
        }
        
        if(r.length()==0)
            return true;
        else
            return false;
        
    }
}
