#include <iostream>

const int size = 11;

class HeapSort{
    public:
        int (&a)[size];

        explicit HeapSort(int (& arr)[size]):a(arr) {}
        int sort() {
            int L, R, n, x;
            n = size;

            L = div(n, 2).quot;
            R = n - 1;
            while (L > 0) {
                //bubble up the biggest value on top of a heap (to a peek)
                L--;
                sift(L, R);
            }
            while (R > 0) {
                //swap the biggest with the last value of a heap
                x = a[0];
                a[0] = a[R];
                a[R] = x;
                //so now the biggest value at the end
                R--;
                //leave it there and don't move it anymore
                sift(L, R);
            }
            return 1;
        };
    private:
        /**
         * Imagine a heap (complete tree):
         *  i - index of peek value
         *  j - index of a first child
         *  R - max possible index of a child
         * @param L
         * @param R
         * @return
         */
        int sift(int L, int R) {
            int i, j, x;
            i = L;
            j = 2 * i + 1;
            x = a[i];
            //if j is lesser than a right sibling, then j becomes an index of this sibling
            if (j < R && a[j] < a[j + 1]) {
                j = j + 1;
            }
            //while i-value is lesser then a j-value
            while (j <= R && x < a[j]) {
                //swap them, because we need to bubble up the biggest
                a[i] = a[j];
                i = j;
                j = 2 * j + 1;
                if (j < R && (a[j] < a[j + 1])) {
                    j = j + 1;
                }
            }
            a[i] = x;

            return 1;
        }
};


int main() {
    const int length = size;
    int arr[length] = {1, 3, 7, 19, 5, 11, 21, 13, 9, 17, 15};
    int i;
    HeapSort sort(arr);

    sort.sort();

    std::cout << "result: \n";
    for (i = 0; i < length; i++) {
        std::cout << arr[i] << std::endl;
    }

    return 0;
}
