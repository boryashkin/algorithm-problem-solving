class Solution {
public:
    int myAtoi(string str) {
        const int MAX = 2147483647;
        const int MIN = -2147483648;
        int i = 0;
        int strEnd = str.size();
        int validState = 0;//0 - search, 1 - number, 2 - negative, 3 - alphabetic

        for (i = 0; i < str.size(); i++) {
            if (validState == 0) {
                if ('0' <= str.at(i) && str.at(i) <= '9') {
                    validState = 1;
                } else if ('-' == str.at(i) || '+' == str.at(i)) {
                    validState = 2;
                } else if (' ' == str.at(i)) {
                    validState = 0;
                } else {
                    validState = 3;
                }
            } else if (validState == 2) {
                if ('0' <= str.at(i) && str.at(i) <= '9') {
                        validState = 1;
                    } else {
                        validState = 3;
                    }
            } else if (validState == 1) {
                if ('0' <= str.at(i) && str.at(i) <= '9') {
                    validState = 1;
                } else {
                    strEnd = i;
                    break;
                }
            }

            if (validState == 3) {
                return 0;
            }
        }
        str = str.substr(0, strEnd);
        int result = 0;
        bool op = false;//0 + 1 -
        int pos = str.size();

        for (i = 0; i < str.size(); i++) {
            pos--;
            if ('0' <= str.at(i) && str.at(i) <= '9') {
                if (op) {
                    if (MIN - result >= (0 - (str.at(i) - '0') * pow(10, pos))) {
                        return MIN;
                    }
                    result -= (str.at(i) - '0') * pow(10, pos);
                } else {
                    if (MAX - result <= (str.at(i) - '0') * pow(10, pos)) {
                        return MAX;
                    }
                    result += (str.at(i) - '0') * pow(10, pos);
                }

            } else if ((' ' == str.at(i) || '+' == str.at(i)) && result == 0) {
                continue;
            } else if ('-' == str.at(i) && result == 0) {
                op = true;
            } else {
                break;
            }
        }

        return result;
    }
};