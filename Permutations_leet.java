class Solution {
    public List<List<Integer>> permute(int[] nums) {
        
        List<List<Integer>> r = new ArrayList<>();
        List<Integer> chosen = new ArrayList<Integer>();
        List<Integer> input = Arrays.stream(nums).boxed().collect(Collectors.toList());
        
        permuteHelper(input,r,chosen); 
        return r;
    }
    static void permuteHelper(List<Integer> input,List<List<Integer>> r, List<Integer> chosen){
        if(input.size()==0){
             
            r.add(new ArrayList<>(chosen));
            
            return;
        }
        for(int i=0;i<input.size();i++){
           int c = input.get(i);
            
            input.remove(i);
            chosen.add(c);
            permuteHelper(input,r,chosen);
           
            input.add(i,c);
            if(chosen.size()>0)
            chosen.remove(chosen.size()-1);
        }
    }
}                               
