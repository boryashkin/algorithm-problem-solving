class StaightMergeSort {
public:
    int (&a)[size];
    int tempA[size];

    explicit StaightMergeSort(int (& arr)[size]):a(arr) {}
    int sort() {
        mergesort(a, 0, size - 1);

        return 1;
    };
    int mergesort(int arr[size], int left, int right) {
       int middle = div(left + right, 2).quot;
       if (left >= right) {
           return 0;
       }
       mergesort(arr, left, middle);
       mergesort(arr, middle + 1, right);
       mergeHalves(arr, left, right);

       return 1;
    }
    int mergeHalves(int arr[size], int leftStart, int rightEnd) {
        int index;
        int leftEnd = div(leftStart + rightEnd, 2).quot;
        int rightStart = leftEnd + 1;

        index = leftStart;
        int left = leftStart;
        int right = rightStart;

        //todo: explain this
        while (left <= leftEnd && right <= rightEnd) {
            if (a[left] <= a[right]) {
                tempA[index] = a[left];
                left++;
            } else {
                tempA[index] = a[right];
                right++;
            }
            index++;
        }
        while (left <= leftEnd) {
            tempA[index] = a[left];
            left++;
            index++;
        }
        while (right <= rightEnd) {
            tempA[index] = a[right];
            right++;
            index++;
        }
        for (index = leftStart; index <= rightEnd; index++) {
            a[index] = tempA[index];
        }
    }
};



int main() {
    const int length = size;
    int arr[length] = {1, 4, 3, 2, 5, 9, 8, 6, 7, 0};
    int i;
    StaightMergeSort sort(arr);

    sort.sort();

    std::cout << "result: \n";
    for (i = 0; i < length; i++) {
        std::cout << arr[i] << std::endl;
    }

    return 0;
}