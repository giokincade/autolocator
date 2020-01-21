#import <Phpoc.h>
#import "Arduino.h"
#import "Socket.h"

Socket::Socket() {
    _server = PhpocServer(80);

    Phpoc.begin(PF_LOG_SPI | PF_LOG_NET);
    _server.beginWebSocket("autolocator");

    Serial.print("Chat server address : ");
    Serial.println(Phpoc.localIP());
}

PhpocClient Socket::_getClient() {
    return _server.available();
}

String Socket::readMessage() {
    PhpocClient client = _getClient();

    if (client) {
        return client.readLine();
    }

    return "";
}

void Socket::writeMessage(String message) {
    char* messageCstr = message.c_str();
    _server.write(messageCstr, message.length());
    //Do we need a flush?
}
