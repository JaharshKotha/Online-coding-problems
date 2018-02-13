class Solution {
    public int[] anagramMappings(int[] A, int[] B) {
        HashMap<Integer,Stack<Integer>> h = new HashMap<Integer,Stack<Integer>>();
        int i=0;
        for(int a:B)
        {
                Stack<Integer> s = h.containsKey(a) ? h.get(a):new Stack<Integer>();
                s.push(i);
                h.put(a,s);
            ++i;
        }
        i=0;
        int []r = new int[A.length];
        for(int b:A)
        {
            Stack<Integer> s = h.get(b);
            r[i]=s.pop();
            ++i;
        }
        
        return r;
        
        
    }
}
