#include <iostream>

int main() {
    const int length = 10;
    int arr[length] = {9, 8, 7, 6, 5, 3, 4, 2, 0, 1};
    int  h[3] = {7, 3, 1};
    int i, j, x, m, k;

    for (m = 0; m < 3; m++) {
        k = h[m];
        for (i = k; i < length; i++) {
            x = arr[i];
            j = i - k;
            while (j >= k && x < arr[j]) {
                arr[j + k] = arr[j];
                j = j - k;
            }
            if (j >= k || x >= arr[j]) {
                arr[j + k] = x;
            } else {
                arr[j + k] = arr[j];
                arr[j] = x;
            }
        }
    }

    std::cout << "result: \n";
    for (i = 0; i < length; i++) {
        std::cout << arr[i] << std::endl;
    }

    return 0;
}
