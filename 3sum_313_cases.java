class Solution {
    public List<List<Integer>> threeSum(int[] nums) {
        HashMap<Integer,ArrayList<Integer>> h = new HashMap<Integer,ArrayList<Integer>>();
        for(int i=0;i<nums.length;i++)
        {
            ArrayList<Integer> t = h.containsKey(nums[i]) ? h.get(nums[i]):new ArrayList<Integer>();
            t.add(i);
            h.put(nums[i],t);
        }
        
        List<List<Integer>> res = new ArrayList<List<Integer>>();
        Set<ArrayList<Integer>> s = new HashSet<ArrayList<Integer>>();
        
        for(int i=0;i<nums.length;i++)
        {
        int t =nums[i],tp=i;
            
            for(int j=0;j<nums.length;j++)
            {
                if(j==tp)
                    continue;
                int find = (t+nums[j])*(-1);
                
                if(h.containsKey(find))
                {
                    ArrayList<Integer> pos = h.get(find);
                    for(int k=0;k<pos.size();k++)
                    {
                        int kget = pos.get(k);
                        
                        if(kget!=j && kget!=i)
                        {
                            ArrayList<Integer> tem = new ArrayList<Integer>();
                            tem.add(nums[kget]);
                            tem.add(nums[j]);
                            tem.add(nums[i]);
                            Collections.sort(tem);
                            s.add(tem);
                        }
                    }
                    
                }
                
            }
            
        
        }
       // System.out.println(s);
        res.addAll(s);
        return res;
    }
}
