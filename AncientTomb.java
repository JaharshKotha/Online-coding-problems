
# Question : https://leetcode.com/discuss/interview-question/1767683/indeed-karat-phone-screening-internship

import java.util.Arrays;

public class AncientTomb {

    public static void main(String args[]){
        System.out.println("Ancient Tomb Problem");
        System.out.println( minDistance("rRBGYygbr"));

    }

    private static int minDistance(String layout){
        int d =0;
        int dist[][] = new int[26][3];
        
        for (int[] row: dist)
            Arrays.fill(row, -1);

        for (int i = layout.length()-1;i>=0;--i){
            char cur = layout.charAt(i);
            if(Character.isUpperCase(cur)){
                dist[cur-'A'][0] = 1;
            }else if(dist[Character.toUpperCase(cur)-'A'][0]==0){
                dist[Character.toUpperCase(cur)-'A'][2] = i;
            }else {
                if(dist[Character.toUpperCase(cur)-'A'][1]==-1)
                    dist[Character.toUpperCase(cur)-'A'][1]=i;
            }
        }

        for(int i=0;i<layout.length();i++){
            char cur = layout.charAt(i);

            if(Character.isUpperCase(cur)){
                int cur_dis =0 ;
                int left_index = dist[Character.toUpperCase(cur)-'A'][1];
                int right_index = dist[Character.toUpperCase(cur)-'A'][2];

                if(left_index==-1 && right_index==-1)
                    continue;

                if(left_index==-1)
                    d = d + (right_index-i);
                else if (right_index==-1)
                    d = d+ (i-left_index);
                else {
                    cur_dis = (i-left_index) > (right_index-i) ? (right_index-i) :  (i-left_index);
                    d+=cur_dis;
                }
            }
            }

    return d;
        }


}
