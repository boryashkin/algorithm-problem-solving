/**
 * Definition for singly-linked list.
 * function ListNode(val) {
 *     this.val = val;
 *     this.next = null;
 * }
 */
/**
 * @param {ListNode} l1
 * @param {ListNode} l2
 * @return {ListNode}
 */
var addTwoNumbers = function(l1, l2) {
    let n1, n2;
    n1 = resolveList(l1);
    n2 = resolveList(l2);

    return makeList(add(n1, n2));
};

function makeList(strNum) {
    let i;
    let item, prevItem = null;
    let len = strNum.length;
    for (i = 0; i < len; i++) {
        item = new ListNode(strNum.substr(i, 1));
        item.next = prevItem;
        prevItem = item;
    }

    return prevItem;
}

function resolveList(list) {
    let number = '';
    while (list !== null) {
        number += resolveList(list.next);
        number += list.val;
        break;
    }

    return number;
}

//addition function from the internet (because of it's was just a check of the algorithm above)
function add(x, y) {
    var demo = '';
    var len;
    var lenx = x.length;
    var leny = y.length;
    var x1,y1,rem,div=0;
    if(lenx>leny) len = lenx; else len = leny;

    for(var i=0;i<len;i++){
        if(i>=lenx) x1  = 0;
        else x1 = parseInt(x[lenx-i-1]);
        if(i>=leny) y1 = 0;
        else y1 = parseInt(y[leny-i-1]);
        rem = (x1+y1+div)%10;
        div = Math.floor((x1 + y1+div)/10);
        demo = rem + demo;
    }
    if(div>0){
        demo = div + demo;
    }
    return demo;
}