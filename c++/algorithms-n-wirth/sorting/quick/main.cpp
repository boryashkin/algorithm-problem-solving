#include <iostream>

const int size = 11;

class QuickSort{
    public:
        int (&a)[size];

        explicit QuickSort(int (& arr)[size]):a(arr) {}
        int sort(int L, int R) {
            int i, j, x, w;
            i = L;
            j = R;

            x = a[div((i + j), 2).quot];

            do {
                while (a[i] < x) {
                    i++;
                }
                while (x < a[j]) {
                    j--;
                }
                if (i <= j) {
                    w = a[i];
                    a[i] = a[j];
                    a[j] = w;
                    i++;
                    j--;
                }
            } while (i <= j);
            if (L < j) {
                sort(L, j);
            }
            if (R > i) {
                sort(i, R);
            }

            return 1;
        };
};


int main() {
    const int length = size;
    int arr[length] = {1, 3, 7, 19, 5, 11, 21, 13, 9, 17, 15};
    int i;
    QuickSort sort(arr);

    sort.sort(0, length - 1);

    std::cout << "result: \n";
    for (i = 0; i < length; i++) {
        std::cout << arr[i] << std::endl;
    }

    return 0;
}