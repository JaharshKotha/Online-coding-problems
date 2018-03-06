class Solution {
    public int numMatchingSubseq(String S, String[] words) {
        int res=0;
        for(String w:words)
        {
            boolean flg=true;
             int pos =0,prev=-1;
            for(int i=0;i<w.length();i++)
            {
                char ch = w.charAt(i);
               
                
                pos= S.indexOf(ch,prev+1);
                //System.out.println(w+" " +pos+" "+ch);
                if(pos!=-1)
                {
                    prev=pos;
                    
                }
                else
                {
                    flg=false;
                    break;
                }
                
            }
           
                
            res=(flg)?res+1:res;
        }
        return res;
    }
}
