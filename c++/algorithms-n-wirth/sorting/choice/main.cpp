#include <iostream>

int main() {
    const int length = 10;
    int arr[length] = {9, 8, 7, 6, 5, 3, 4, 2, 1, 0};
    int i, j, x, smallestI;

    for (i = 0; i < length - 1; i++) {
        j = i + 1;
        x = arr[i];
        smallestI = i;
        while (j < length) {
            if (x > arr[j]) {
                smallestI = j;
                x = arr[smallestI];
            }
            j++;
        }
        arr[smallestI] = arr[i];
        arr[i] = x;
    }

    std::cout << "result: \n";
    for (i = 0; i < length; i++) {
        std::cout << arr[i] << std::endl;
    }

    return 0;
}