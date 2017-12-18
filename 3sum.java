class Solution {
    public List<List<Integer>> threeSum(int[] nums) {
        int [][] tem = new int [nums.length][nums.length];
        for(int i=0;i<nums.lenght;i++)
        {
            for(int j=0;j<nums.length;j++)
            {
                tem[i][j] = nums[i]+nums[j];
            }
        }
        
        HashMap<Integer,ArrayList<Integer>> h = new  HashMap<Integer,ArrayList<Integer>>();
        
        
        for(int i=0;i<nums.length;i++)
            h.add(nums[i]);
        
        for(int i=0;i<nums.lenght;i++)
        {
            for(int j=0;j<nums.length;j++)
            {
                int t = nums[i][j];
                
            }
        }
    }
}
