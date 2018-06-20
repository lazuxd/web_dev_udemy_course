#include <bits/stdc++.h>

using namespace std;

int setBit(int x, int i, int b) {
    if (b == 0) {
        return x & (~(1<<i));
    } else {
        return x | (1<<i);
    }
}

int maximizingXor(int l, int r) {
    int n = 31, x = 0, a = l, b = r;
    while ((r>>n & 1) == 0) --n;
    for (; n>=0; n--) {
        if (setBit(a, n, 0) >= l && setBit(b, n, 1) <= r) {
            a = setBit(a,n,0); b = setBit(b,n,1);
            x = setBit(x, n, 1);
            continue;
        }
        if (setBit(a, n, 1) <= r && setBit(b, n, 0) >= l) {
            a = setBit(a,n,1); b = setBit(b,n,0);
            x = setBit(x, n, 1);
        }
    }

    return x;
}

int main() {
    int l;
    cin >> l;
    int r;
    cin >> r;
    int result = maximizingXor(l, r);
    cout << result << endl;
    return 0;
}

