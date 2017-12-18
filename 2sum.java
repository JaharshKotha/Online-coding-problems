class Solution {
    public int[] twoSum(int[] nums, int target) {
        int [] res = new int[2];
        HashMap<Integer,Integer> h = new HashMap<Integer,Integer>();
        for(int i=0;i<nums.length;i++)
        {
            h.put(nums[i],i);
        }
        
        for(int i=0;i<nums.length;i++)
        {
            int ch = target - nums[i];
            if(h.containsKey(ch))
            {
                int index = h.get(ch);
                if(index == i)
                    continue;
                
                res[0] = index;
                res[1] = i;
                return res;
            }
            
        }
        return res;
    }
}
