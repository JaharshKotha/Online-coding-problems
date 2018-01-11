class Solution {
    
    public static class point
    {
        int x;
        int y;
        
        point(int x,int y)
        {
            this.x = x;
            this.y=y;
        }
    }
    
    static boolean checkb(int i,int j,int rl,int cl)
    {
        return ((i>=0 && i<rl)&&(j>=0 && j<cl)) ? true:false;
    }
    static void bfs(char[][] grid,boolean[][] m,int i,int j)
    {
        ArrayList<point> q = new ArrayList<point>();
        
        point st = new point(i,j);
        q.add(st);
        while(!q.isEmpty())
        {
            point curr = q.get(0);
            q.remove(0);
            
            m[curr.x][curr.y] = true;
            
            int li =curr.x-1,lj=curr.y,ri=curr.x+1,rj=curr.y,ui=curr.x,uj=curr.y+1,di=curr.x,dj=curr.y-1;
            
            if(checkb(li,lj,grid.length,grid[0].length))
            {
                if(!m[li][lj] && grid[li][lj]=='1')
                {point l = new point(li,lj);
                q.add(l);
                    
                }
                
            }
            
            if(checkb(ri,rj,grid.length,grid[0].length))
            {
                if(!m[ri][rj] && grid[ri][rj]=='1')
                {point r = new point(ri,rj);
                q.add(r);
                    
                }
                
            }
            
            if(checkb(ui,uj,grid.length,grid[0].length))
            {
                if(!m[ui][uj] && grid[ui][uj]=='1')
                {point u = new point(ui,uj);
                q.add(u);
                    
                }
                
            }
            
            if(checkb(di,dj,grid.length,grid[0].length))
            {
                if(!m[di][dj] && grid[di][dj]=='1' )
                {
                point d = new point(di,dj);
                q.add(d);
                    
                }
                
            }
        }
        
    }
    
    public int numIslands(char[][] grid) {
        
        if(grid.length == 0)
        {
            return 0;
        }
        
        boolean[][] m = new boolean[grid.length][grid[0].length];
        int ans=0;
        
        for(int i=0;i<grid.length;i++)
        {
            for(int j=0;j<grid[0].length;j++)
            {
                if(grid[i][j] =='1' && !m[i][j])
                {
                    ++ans;
                    bfs(grid,m,i,j);
                }
            }
        }
        
        return ans;
        
    }
}
