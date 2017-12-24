class Solution {
    public int findMin(int[] nums) {
        
        if(nums.length ==1)
            return nums[0];
       
        return findMin(nums,0,nums.length-1);
    }
 static int findMin(int[] nums,int l ,int h)
 {
     
     int m = (l+h)/2;
     
     if(m==0)
         return (nums[0]>nums[1])?nums[1]:nums[0];
     if(m== nums.length-1)
         return nums[m];
     
     if(nums[m]<nums[m-1] && nums[m]<nums[m+1] )
         return nums[m];
     
     
     
     if(nums[m] > nums[h])
         return findMin(nums,m+1,h);
     else
         return findMin(nums,l,m-1);
 } 

}
