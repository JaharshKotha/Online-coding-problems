
import java.util.*;

public class test {

	public static void subarraySum(int[] b,int[] c,int k) {
		ArrayList<Double> a = new ArrayList<Double>();
		HashMap<Double,Integer> h = new HashMap<Double,Integer>();
		
		for(int i=0;i<b.length;i++)
			{a.add((double)c[i]/b[i]);
			h.put(a.get(i),b[i]);
			}
		System.out.println(h);
		Collections.sort(a);
		int ans=0,r=0;
		for(int i=0;i<a.size();i++)
		{
			System.out.println(a.get(i));
			
			double n = Math.floor(k/a.get(i));
			System.out.println(n);
			double f = n*a.get(i);
			f=Math.ceil(f);
			if(f==0)
				break;
			if(k-f>=0)
			{
				int tb = h.get(a.get(i));
				int tem=(int)(n/tb);
				System.out.println("f="+f);
				System.out.println(tb);
				ans+=tem*tb;
				if(tem==0)
					break;
				
				
				k=k-(int)f;
				System.out.println("k="+k);
			}
			else
				break;
			
			
			
		}
		
		System.out.println(ans);
		
		
		}
	
	public static void main(String args[]){
		int[] n = {20,19};
		int[] c = {24,20};
		int k=50;
		
		subarraySum(n,c,k);
	}
}
