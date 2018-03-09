 void LevelOrder(Node root)
    {
       ArrayList<ArrayList<Integer>> p = new ArrayList<ArrayList<Integer>>();
       
       help(p,root,0);
       for(int i=0;i<p.size();i++)
           {
           ArrayList<Integer> x= p.get(i);
           for(int j=0;j<x.size();j++)
           {
           System.out.print(x.get(j)+" ");
           }
       }
       
      
      //System.out.println(p);
    }
    void help( ArrayList<ArrayList<Integer>> p ,Node root,int level)
        {
        if(root==null)
            return;
      if(p.size()>level)
          {
          ArrayList<Integer> x= p.get(level);
           
         
           x.add(root.data);
        p.set(level,x);
          //System.out.println(x+"" +root.data+" "+level);
      }
        else
            {
           ArrayList<Integer> x= new ArrayList<Integer>();
           
             x.add(root.data);
        p.add(level,x);
            //System.out.println(x+ ""+root.data+" "+level);
        }
        
           
     
        
       
        //System.out.println(p + " "+root.data+" "+level );
        help(p,root.left,++level);
        help(p,root.right,level);
         
    }
