#ifndef Socket_h
#define Socket_h

#include <Phpoc.h>
#include "Arduino.h"

struct Command {
  String key;
  String value;
};

class Socket {
  public:
    Socket(char* address);
    void setup(Stream *streamObject);
    const String& read();
    const String& getMessage();
    const Command& getCommand();
    void write(char* message);
  private:
    PhpocClient _getClient();
    char* _address;
    Stream* _stream;
    PhpocClient _client;
    String _message;
    String _buffer;
    Command _command;
};

#endif
