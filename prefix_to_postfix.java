public static String preToPost(String infix) {
      char curChar;
      int infixLength = infix.length();
      String postFix = "";
      Stack<Character> newStack = new Stack<Character>();
      for (int x = 0; x < infix.length(); x++) {
    	  System.out.println("stack="+newStack);
    	  System.out.println("postfix="+postFix);
         curChar = infix.charAt(x);
         if (isOperator(curChar)) {
            newStack.push(curChar);
         } else {
            if (!isOperator(curChar)) 
              postFix = postFix + curChar;
            while (!newStack.isEmpty() && newStack.peek() == '#') {
               newStack.pop();
               postFix = postFix + newStack.pop();
               // newStack.pop();
            }
          newStack.push('#');
         }
      }
    return postFix;
   }               
   public static boolean isOperator(char op) {
      if (op == '+' || op == '-' || op == '*' || op  == '/') {
         return true;
      } else {
         return false;
      }
   }
}
