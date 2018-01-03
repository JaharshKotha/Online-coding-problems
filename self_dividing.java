class Solution {
    public List<Integer> selfDividingNumbers(int left, int right) {
        List<Integer> l = new ArrayList<Integer>();
        for(int i=left;i<=right;i++)
        {
            int flg=0;
            int t1 = i,t2=i;
           // System.out.println(i);
            while(t2>0)
            {
                int k = t2%10;
                
                if(k==0 || t1%k!=0 )
                {flg=1; break;}
                    t2=t2/10;
                
            }
            if(flg==1)
                continue;
            else
                l.add(i);
            
        }
        
        return l;
    }
}
