class Solution {
    public boolean judgeCircle(String moves) {
        String r="";
        int u=0,l=0;
        
        char[] ca=moves.toCharArray();  
        
        for(char c: ca)
        {
            if(c=='U')
                {u+=1;}
            if(c=='D')
            {
               u-=1;
                
            }
            
            if(c=='R')
            {l+=1;}
            
           if(c=='L')
            {
                l-=1;
            } 
        }
        
        if(u==0 && l==0)
            return true;
        else
            return false;
        
    }
}
