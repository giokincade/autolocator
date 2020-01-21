#include <Phpoc.h>

class Socket {
    public:
        Socket(String path = "autolocator", int port = 80);
        String readMessage();
        void writeMessage(String message);

    private:
        PhpocClient _getClient();
        PhpocServer _server = NULL;
};
