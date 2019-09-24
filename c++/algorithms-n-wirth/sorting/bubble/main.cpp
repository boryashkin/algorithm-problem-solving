#include <iostream>

int main() {
    const int length = 10;
    int arr[length] = {9, 8, 7, 6, 5, 3, 4, 2, 1, 0};
    int i, j, x;

    for (i = 0; i < length; i++) {
        for (j = length - 1; j > i; j--) {
            if (arr[j - 1] > arr[j]) {
                x = arr[j - 1];
                arr[j - 1] = arr[j];
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