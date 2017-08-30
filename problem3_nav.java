import java.io.*;
import java.util.*;
import java.util.HashMap;
import java.util.ArrayList;
import java.text.DecimalFormat;
import java.util.Formatter;

public class Main {
  public static void main(String[] args) throws IOException {
    BufferedReader in = new BufferedReader(new InputStreamReader(System.in));
    String s;
    while ((s = in.readLine()) != null) {
     HashMap<String, Double> bench_values = new HashMap<String, Double>();
     double total =0.0;
     
     ArrayList<String> portfolios = new ArrayList<String>();
     
    
    int cnt=0;
     
     for (int i = -1; (i = s.indexOf("|", i + 1)) != -1; i++) {
    portfolios.add(s.substring(cnt,i));
    cnt = i+1;
        }
        portfolios.add(s.substring(cnt,s.length()));


     for(int i=0;i<portfolios.size();i++)
     {
         
          String [] portfolio = portfolios.get(i).split(":");
           portfolio[0] = portfolio[0].replaceAll("\\s",""); 
           
         if(portfolio[0].equals("BENCH"))
         { 
             
             
          String [] bench_stocks = portfolio[1].split(";");
            //System.out.println(bench_stocks[0]);          
          for(int j=0;j<bench_stocks.length ; j++)
          {
              String [] bench_stock = bench_stocks[j].split(",");
              double qty = Double.parseDouble(bench_stock[1]);
              double price = Double.parseDouble(bench_stock[2]);
              
              total+=(qty*price);
                
               
          }
          
          for(int j=0;j<bench_stocks.length ; j++)
          {
              String [] bench_stock = bench_stocks[j].split(",");
              double qty = Double.parseDouble(bench_stock[1]);
              double price = Double.parseDouble(bench_stock[2]);
              
              bench_values.put(bench_stock[0],((qty*price)*100) / total );
                  
          }
          
           
           
         }
     }
     
     Collections.sort(portfolios);
      String pattern = "#0.00";
      DecimalFormat decimalFormat = new DecimalFormat(pattern);
     
      for(int i=0;i<portfolios.size();i++)
     {
         
          String [] portfolio = portfolios.get(i).split(":");
           portfolio[0] = portfolio[0].replaceAll("\\s",""); 
           
         if(!portfolio[0].equals("BENCH"))
         { 
            double other_totals =0; 
             
          String [] other_stocks = portfolio[1].split(";");
            //System.out.println(bench_stocks[0]);          
          for(int j=0;j<other_stocks.length ; j++)
          {
              String [] other_stock = other_stocks[j].split(",");
              double qty = Double.parseDouble(other_stock[1]);
              double price = Double.parseDouble(other_stock[2]);
              
              other_totals+=(qty*price);
                
               
          }
          
          String ans = "";
          
          for(int j=0;j<other_stocks.length ; j++)
          {
              String [] other_stock = other_stocks[j].split(",");
              double qty = Double.parseDouble(other_stock[1]);
              double price = Double.parseDouble(other_stock[2]);
              
              
              double tem = (((qty*price)*100) / other_totals);
              
              double bench_val = 0;
              if(bench_values.containsKey(other_stock[0]))
              {
                   bench_val = bench_values.get(other_stock[0]);
              
              }
              
              double a = (double) Math.round((tem-bench_val) * 100) / 100 ;
             

            String format = decimalFormat.format(a);
            

              ans+=(other_stock[0]+":"+format+",");
              
              
             
                  
          }
          ans = ans.substring(0,ans.length()-1);
          
          Iterator it = bench_values.entrySet().iterator();
    while (it.hasNext()) {
        Map.Entry pair = (Map.Entry)it.next();
        //String k = pair.getKey();
        if(!ans.contains(String.valueOf(pair.getKey())))
        {
            
             String tem =  String.valueOf(pair.getValue());
           

            String format = decimalFormat.format(Double.parseDouble(tem));
            
            
            ans+=","+pair.getKey()+":-"+ format;
        }
        
        it.remove(); 
    }
          
          System.out.print(ans);
           
           
         }
     }
     
     
     
     
    }
  }
}
