// Arduino communicates with PHPoC [WiFi] Shield via pins 10, 11, 12 and 13 on
// the Uno, and pins 10, 50, 51 and 52 on the Mega. Therefore, these pins CANNOT
// be used for general I/O.

#include "Arduino.h"
#include "Socket.h"

String message = "";
Socket socket = Socket("autolocator");

int RECORD = 2;
int PLAY = 3;
int digitalPins[] = { RECORD, PLAY };

void setup() {
  Serial.begin(9600);
  while(!Serial);

  socket.setup(&Serial);

  // setup pins
  for(int i=0; i<sizeof(digitalPins); i++) {
     pinMode(digitalPins[i], OUTPUT);
  }
}

void loop() {
  processMessage(socket.read());
  socket.write("playhead_time/1$");
}

void processMessage(String message) {
  if (message.length() <= 0) return;

  int delimiterIndex = message.indexOf('/');
  String key = message.substring(0, delimiterIndex);
  String value = message.substring(delimiterIndex + 1, message.length());

  Serial.println(key);
  Serial.println(value);

  for (int i=0; i<sizeof(digitalPins); i++) {
    int pinValue = value == "1" ? LOW : HIGH;
    int pin = digitalPins[i];

    if (key == "rec") {
      digitalWrite(RECORD, pinValue);
    } else if (key == "play") {
      digitalWrite(PLAY, pinValue);
    } else {
      digitalWrite(pin, HIGH);
    }
  }
}
