
//Time Limit exceeds

class Solution {
    public static <Integer> boolean listEqualsIgnoreOrder(List<Integer> list1, List<Integer> list2) {
    return new HashSet<>(list1).equals(new HashSet<>(list2));
}
    
    public List<List<Integer>> threeSum(int[] nums) {
        int [][] tem = new int [nums.length][nums.length];
        for(int i=0;i<nums.length;i++)
        {
            for(int j=0;j<nums.length;j++)
            {
                tem[i][j] = nums[i]+nums[j];
            }
        }
         
        HashMap<Integer,ArrayList<Integer>> h = new  HashMap<Integer,ArrayList<Integer>>();
        for(int i=0;i<nums.length;i++)
        {
            ArrayList<Integer> c;
            if(h.containsKey(nums[i]))
            {
                 c = h.get(nums[i]);
            }
            else
                c= new ArrayList<Integer>();
            
            c.add(i);
            h.put(nums[i],c);
        }
        List<List<Integer>> result =new ArrayList<List<Integer>>();
        
        for(int i=0;i<nums.length;i++)
        {
            for(int j=0;j<nums.length;j++)
            {
                if(j==i)
                    break;
                int t ;
                t= tem[i][j];
                int ch = t*-1;
                if(h.containsKey(ch) && i!=j )
                {
                    ArrayList<Integer> c = h.get(ch);
                    
                    for(int e=0;e<c.size();e++)
                    {
                        int key = c.get(e);
                        if(key!=i && key!=j)
                        {
                            List<Integer> store = new ArrayList<Integer>();
                            store.add(nums[i]);
                            store.add(nums[j]);
                            store.add(nums[key]);
                            int flg=0;
                            for(int ko=0;ko<result.size();ko++)
                            {
                                List<Integer> koc= result.get(ko);
                                if(listEqualsIgnoreOrder(koc,store))
                                {flg=1; break;}
                                
                            }
                            if(flg==0)
                            result.add(store);
                         }
                    }
                    
                }
                
            }
        }
        return result;
    }
}
