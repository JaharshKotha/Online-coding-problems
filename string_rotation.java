class Solution {
    public boolean rotateString(String A, String B) {
        
        String tem=A;
        A = A.charAt(A.length() - 1) + A.substring(0, A.length() - 1);
        while(true)
        {
        if(A.equals(tem))
        {
            break;
           
        }
        else if(A.equals(B))
            return true;
        else
             A = A.charAt(A.length() - 1) + A.substring(0, A.length() - 1);
        }
        return false;
        
    }
}
