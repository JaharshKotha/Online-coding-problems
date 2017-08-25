import java.util.stream.Collectors;
public class Solution {
	public ArrayList<String> letterCombinations(String a) {
	    
	    Map<Character, List<Character>> dict = new HashMap();
	    dict.put('0', Arrays.asList('0'));
	    dict.put('1', Arrays.asList('1'));
	    dict.put('2', Arrays.asList('a', 'b', 'c'));
	    dict.put('3', Arrays.asList('d', 'e', 'f'));
	    dict.put('4', Arrays.asList('g', 'h', 'i'));
	    dict.put('5', Arrays.asList('j', 'k', 'l'));
	    dict.put('6', Arrays.asList('m', 'n', 'o'));
	    dict.put('7', Arrays.asList('p', 'q', 'r', 's'));
	    dict.put('8', Arrays.asList('t', 'u', 'v'));
	    dict.put('9', Arrays.asList('w', 'x', 'y', 'z'));
	    
	    //initialize array to store the final result
	    ArrayList<String> result = new ArrayList<>();
	    
	    //initialize array to store the intermediate results
	    List<Character> subResult = new ArrayList<>();
	    
	    backTrack(a, 0, dict, subResult, result);
	    return result;
	}
	
	private void backTrack(String input, int start, Map<Character, List<Character>> dict, List<Character> subResult, ArrayList<String> result) {
	    if (subResult.size() == input.length()) {
	        //convert the list of chars to String
	        result.add(subResult.stream().map(c -> c.toString()).collect(Collectors.joining()));
	        return;    
	    }
	    List<Character> temp;
	    for (int i=start; i < input.length(); i++) {
	        List<Character> charList = dict.get(input.charAt(i));
	        for (int j=0; j < charList.size(); j++) {
	            // get the existing sub-result and proceed from there onwards
    	        temp = new ArrayList<>(subResult);
    	        temp.add(charList.get(j));
    	        backTrack(input, i+1, dict, temp, result);
	        }
	    }
	}
}
