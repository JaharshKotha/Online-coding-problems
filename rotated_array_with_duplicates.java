class Solution {
    public int findMin(int[] nums) {
        
        if(nums.length ==1)
            return nums[0];
       
        return findMin(nums,0,nums.length-1);
    }
 static int findMin(int[] nums,int l ,int h)
 {
     
     int m = (l+h)/2;
     System.out.println(m);
     if(m==0)
         return (nums[0]>nums[1])?nums[1]:nums[0];
     if(m== nums.length-1)
         return nums[m];
     
     if(nums[m]<nums[m-1] && nums[m]<=nums[m+1] )
         return nums[m];
     
     
     
     if(nums[m] > nums[h])
     {
         int p =0;
         for(p=m;p<h;p++)
         {
             if(nums[p] == nums[p+1])
                 continue;
             else
                 break;
         }
         return findMin(nums,m+1,h);
     }
         
     else
     {
         int p=0;
         for(p=m;p>0;--p)
         {
             if(nums[p] == nums[p-1])
                 continue;
             else
                 break;
         }
         
         return findMin(nums,l,m-1);
         
     }
         
 } 

}
