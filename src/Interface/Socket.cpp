#include <Phpoc.h>
#include "Socket.h"

PhpocServer server(80);

Socket::Socket(char* address) {
  _address = address;
}

void Socket::setup(Stream *streamObject) {
  _stream = streamObject;

  // initialize PHPoC [WiFi] Shield:
  Phpoc.begin(PF_LOG_SPI | PF_LOG_NET);

  // start WebSocket server
  server.beginWebSocket("autolocator");

  // print IP address of PHPoC [WiFi] Shield to serial monitor:
  _stream->print("WebSocket server address : ");
  _stream->println(Phpoc.localIP());
}

PhpocClient Socket::_getClient() {
  return server.available();
}

const String& Socket::read() {
  _message = "";

  PhpocClient client = _getClient();
  if (client && client.available() > 0) {
    char c = client.read();
    if (c == '$') {
      _message = _buffer;
      _buffer = "";
    } else {
      _buffer.concat(c);
    }
  }

  return _message;
}

const String& Socket::getMessage() {
  return _message;
}

const Command& Socket::getCommand() {
  return _command;
}

void Socket::write(char* message) {
  PhpocClient client = _getClient();
  if (client) {
    client.write(message);
  }
}
