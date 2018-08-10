class Solution {
    static boolean oppositeSigns(int x, int y)
    {
        return ((x ^ y) < 0);
    }
    public boolean escapeGhosts(int[][] ghosts, int[] target) {
            int jumps = Math.abs(target[0])+Math.abs(target[1]); 
        for(int i=0;i<ghosts.length;i++){ 
            int lgjumps=0,rgjumps=0;
            if(oppositeSigns(target[0],ghosts[i][0])){
            lgjumps = Math.abs(target[0])+Math.abs(ghosts[i][0]); 
        }else{
            lgjumps = Math.abs(ghosts[i][0] -target[0]);
        }
           if(oppositeSigns(target[0],ghosts[i][0])){
            rgjumps = Math.abs(target[1])+Math.abs(ghosts[i][1]); 
        }else{
            rgjumps = Math.abs(ghosts[i][1] -target[1]);
        }                       
            if((rgjumps + lgjumps)<=jumps)
                return false;
        }
        return true;
    }
}
