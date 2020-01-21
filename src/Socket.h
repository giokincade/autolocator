#include <Phpoc.h>

class Socket {
    public:
        Socket();
        String readMessage();
        void writeMessage(String message);

    private:
        PhpocClient _getClient();
        PhpocServer _server = NULL;
};
