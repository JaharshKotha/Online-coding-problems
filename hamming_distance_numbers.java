class Solution {
    public int hammingDistance(int x, int y) {
     
        int z = x^y;
        int r=0;
        while(z>0)
        {
            if((z&1)==1)
                ++r;
            z= z>>1;
        }
        
        return r;
    }
}
