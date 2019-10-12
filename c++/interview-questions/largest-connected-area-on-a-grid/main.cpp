#include <iostream>
#include <stack>

using namespace std;

/**
 * Largest connected component on a grid
 *
 * returning a first node of a grid and a number of connected nodes
 */
int count = 0;

const int xAx = 8;
const int yAx = 6;
int input[yAx][xAx] = {
        {1, 4, 4, 4, 4, 3, 3, 1},
        {2, 1, 1, 4, 3, 3, 1, 1},
        {3, 2, 1, 1, 2, 3, 2, 1},
        {3, 3, 2, 1, 2, 2, 2, 2},
        {3, 1, 3, 1, 1, 4, 4, 4},
        {1, 1, 3, 1, 1, 4, 4, 4},
};
//const int xAx = 3;
//const int yAx = 3;
//int input[yAx][xAx] = {
//        {0, 1, 0},
//        {0, 1, 0},
//        {1, 1, 1},
//};
enum DIRECTION {RIGHT, BOTTOM, LEFT, TOP};
struct Node {
    //pair <x, y> i.e. Node.current.first = x, Node.current.second = y.
    std::pair<int, int> right;
    std::pair<int, int> bottom;
    std::pair<int, int> left;
    std::pair<int, int> top;
    std::pair<int, int> current;
};
struct HashTable {
public:
    HashTable() {
        int i = 0;
        for (i = 0; i < arraySize; i++) {
            visited[i] = -1;
        }
    }
    bool isset(Node key) {
        int hashKey = getHashedKey(key);

        return visited[hashKey] != -1;
    }
    void set(Node key, int value) {
        int hashKey = getHashedKey(key);
        visited[hashKey] = value;
    }

private:
    int const static arraySize = xAx * yAx;
    int static getHashedKey(Node key) {
        return div(xAx * key.current.second + key.current.first, arraySize).rem;
    }
    int visited[arraySize] = {};
};
HashTable hashTable;

Node buildNodeFromCoodrs(std::pair<int, int> coords) {
    Node node = {
            {coords.first + 1, coords.second},
            {coords.first, coords.second + 1},
            {coords.first - 1, coords.second},
            {coords.first, coords.second - 1},
            {coords.first, coords.second}
    };

    return node;
}
bool isCoordsInBounds(std::pair<int, int> coords) {
    return coords.first < xAx && coords.second < yAx && coords.first >= 0 && coords.second >= 0;
}
bool isNodeVisited(Node node) {
    return hashTable.isset(node);
}

/**
 * @param node
 * @param prev 1 - right, 2 - bottom, 3 - left, 4 - top
 * @return
 */
Node getNextNodeToExplore(Node node, DIRECTION direction) {
    Node nextNode;
    int cellValue = input[node.current.second][node.current.first];
    if (!isCoordsInBounds(node.current)) {
        std::cout << "/same/ [curr node is out of bounds]" << std::endl;
        return node;
    }

    if (direction == RIGHT && isCoordsInBounds(node.right) && cellValue == input[node.right.second][node.right.first]) {
        std::cout << "right" << std::endl;
        nextNode = buildNodeFromCoodrs(node.right);
    } else if (direction == BOTTOM && isCoordsInBounds(node.bottom) && cellValue == input[node.bottom.second][node.bottom.first]) {
        std::cout << "bottom" << std::endl;
        nextNode = buildNodeFromCoodrs(node.bottom);
    } else if (direction == LEFT && isCoordsInBounds(node.left) && cellValue == input[node.left.second][node.left.first]) {
        std::cout << "left" << std::endl;
        nextNode = buildNodeFromCoodrs(node.left);
    } else if (direction == TOP && isCoordsInBounds(node.top) && cellValue == input[node.top.second][node.top.first]) {
        std::cout << "top" << std::endl;
        nextNode = buildNodeFromCoodrs(node.top);
    } else {
        std::cout << "/same/" << std::endl;
        nextNode = node;
    }

    return nextNode;
}
int DFS(Node node) {
    Node nextNode;
    int res = 1;

    std::cout << "DFS: " << count++ << std::endl;
    if (hashTable.isset(node)) {
        return res;
    }
    hashTable.set(node, input[node.current.second][node.current.first]);

    nextNode = getNextNodeToExplore(node, RIGHT);
    if (nextNode.current != node.current && !isNodeVisited(nextNode)) {
        res += DFS(nextNode);
    }

    nextNode = getNextNodeToExplore(node, BOTTOM);
    if (nextNode.current != node.current && !isNodeVisited(nextNode)) {
        res += DFS(nextNode);
    }

    nextNode = getNextNodeToExplore(node, LEFT);
    if (nextNode.current != node.current && !isNodeVisited(nextNode)) {
        res += DFS(nextNode);
    }

    nextNode = getNextNodeToExplore(node, TOP);
    if (nextNode.current != node.current && !isNodeVisited(nextNode)) {
        res += DFS(nextNode);
    }

    return res;
}
int main()
{
    int x, y, res;
    res = 0;
    HashTable results;

    for (y = 0; y < yAx; y++) {
        for (x = 0; x < xAx; x++) {
            Node node = buildNodeFromCoodrs({x, y});
            res = DFS(node);
            results.set(node, res);

            std::cout << "main DFS(" << x << ", " << y << "); result: " << res << " nodes connected" << std::endl;
        }
    }

    return res;
}
