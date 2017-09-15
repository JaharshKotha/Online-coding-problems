static String[] braces(String[] values) {
        String [] res = new String[values.length];
        Stack<Character> s = new Stack<Character>();
        for(int i=0;i<values.length;i++)
        {
            int flg=0;
            String t =values[i]; 
            for(int j=0;j<t.length();j++)
            {
                if((t.charAt(j)=='{')||(t.charAt(j)=='[')||(t.charAt(j)=='('))
                {
                    s.push(t.charAt(j));
                }
                
                if((t.charAt(j)=='}')||(t.charAt(j)==']')||(t.charAt(j)==')'))
                {
                    Character test = s.pop();
                    if((t.charAt(j)=='}'))
                    {
                        if(test=='{')
                            continue;
                        else
                        {res[i]="NO";flg=1;break;}
                    }
                    if((t.charAt(j)==']'))
                    {
                        if(test=='[')
                            continue;
                        else
                        {res[i]="NO";flg=1;break;}
                    }
                    if((t.charAt(j)==')'))
                    {
                        if(test=='(')
                            continue;
                        else
                        {res[i]="NO";flg=1;break;}
                    }
                }
                if(flg!=1)
                res[i] = "YES";
                
                
            }
        }
    return res;
    }
