class Deque {
    int buffSize = 10;
    int* buffer = nullptr;
    int* tmpBuffer = nullptr;
    int front = 0;
    int back = 0;
public:
    Deque()
    {
        buffer = new int[buffSize];
    }
    ~Deque()
    {
        delete[] buffer;
    }
    int pushFront(int value)
    {
        if (checkIsFull()) {
            increaseBuffer();
        }
        front = (front +  buffSize - 1) % buffSize;
        buffer[front] = value;
        //std::cout << "pushFr[" << front << "]: " << value << std::endl;

        return -1;
    }
    int popFront()
    {
        int result;
        if (front == back) {
            return -1;
        }
        result = buffer[front];
        front = (front + 1) % buffSize;

        return result;
    }
    int pushBack(int value)
    {
        if (checkIsFull()) {
            increaseBuffer();
        }
        buffer[back] = value;
        //std::cout << "pushBa[" << back << "]: " << value << std::endl;
        back = (back + 1) % buffSize;

        return -1;
    }
    int popBack()
    {
        int result;
        if (front == back) {
            return -1;
        }
        back = (back + buffSize - 1) % buffSize;
        result = buffer[back];

        return result;
    }

private:
    bool checkIsFull()
    {
        return (front +  buffSize - 1) % buffSize == back;
    }
    bool increaseBuffer()
    {
        //std::cout << "increasing" << std::endl;
        int i, k;
        i = 0;
        k = front;
        //std::cout << "front: " << front << "; back: " << back << std::endl;
        tmpBuffer = new int[buffSize * 2];
        while (k != back) {
            //std::cout << "k: " << k << "; TO i: " << i << std::endl;
            tmpBuffer[i] = buffer[k];
            k = (k + 1) % buffSize;
            i++;
        }
        delete[] buffer;
        buffer = tmpBuffer;
        front = 0;
        back = i;
        //std::cout << "front: " << front << "; back: " << back << std::endl;
        buffSize *= 2;

        return true;
    }
}
