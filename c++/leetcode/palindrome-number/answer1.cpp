class Solution {
public:
    bool isPalindrome(int x) {
        div_t r;
        std::vector<int> num;
        long unsigned i = 0;
        long unsigned l = 0;

        r = div(x, 1);
        std::cout << "initial: " << r.quot << "." << r.rem << ";\n";

        if (x == 0) {
            std::cout << "zero value";
            return true;
        }
        if (x < 0) {
            std::cout << "negative";
            return false;
        }

        while (r.quot != 0 || r.rem != 0) {
            r = div(r.quot, 10);
            num.push_back(r.rem);
            std::cout << "step: " << r.quot << "." << r.rem << ";\n";
        }
        num.pop_back();

        l = num.size() - 1;
        for (i = 0; i <= l; i++) {
            if (num[i] != num[l - i]) {
                std::cout << num[i] << " == " << num[l - i] << ": -\n";
                return false;
            } else {
                std::cout << "+";
            }
        }

        return true;
    }
};