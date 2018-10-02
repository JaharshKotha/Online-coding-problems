  /**
         * Definition for singly-linked list.
         * public class ListNode {
         *     int val;
         *     ListNode next;
         *     ListNode(int x) { val = x; }
         * }
         */
        class Solution {
            public ListNode addTwoNumbers(ListNode l1, ListNode l2) {
                ListNode ans = null, prev = null;

                int carry = 0;
                while (l1 != null && l2 != null) {

                    int sum = l1.val + l2.val + carry;
                    carry = sum / 10;
                    ListNode l = new ListNode(sum % 10);
                    //System.out.println(sum);
                    if (ans == null) {
                        ans = l;
                        prev = l;
                    } else {
                        prev.next = l;
                        prev = l;
                    }
                    l1 = l1.next;
                    l2 = l2.next;

                }

                if (l1 == null && l2 != null) {
                    prev.next = l2;
                    while (carry != 0 && l2 != null) {

                        int sum = l2.val + carry;
                        l2.val = sum % 10;
                        carry = sum / 10;

                        prev.next = l2;
                        prev = l2;
                        l2 = l2.next;

                    }
                }

                if (l1 != null && l2 == null) {
                    prev.next = l1;
                    while (carry != 0 && l1 != null) {
                        int sum = l1.val + carry;
                        l1.val = sum % 10;
                        carry = sum / 10;

                        prev.next = l1;
                        prev = l1;
                        l1 = l1.next;

                    }
                }

                if (carry != 0) {
                    ListNode l = new ListNode(1);
                    prev.next = l;
                }
                return ans;
            }
        }
