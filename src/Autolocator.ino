// Arduino communicates with PHPoC [WiFi] Shield via pins 10, 11, 12 and 13 on
// the Uno, and pins 10, 50, 51 and 52 on the Mega. Therefore, these pins CANNOT
// be used for general I/O.

#include "Arduino.h"
#include "Socket.h"
#include "Clock.h"
#include "State.h"

#ifndef Autolocator_ino
#define Autolocator_ino

Socket socket = Socket("autolocator");

static const int pulseInputPin = 2;
static const int directionInputPin = A0;

static Clock clock = Clock(directionInputPin, 40.0);

void setup() {
    Serial.begin(9600);
    while(!Serial);

    socket.setup(&Serial);

    pinMode(pulseInputPin, INPUT_PULLUP);
    attachInterrupt(
        digitalPinToInterrupt(pulseInputPin),
        handleTachPulse,
        RISING
    );
}

static void handleTachPulse() {
    //attachInterupt can only take functions with no parameters, so object member functions don't work by default.
    //Theoretically if we had access to the CPP std lib we could use bind, but that's also not an option.
    //So instead, we have this shitty global wrapper.
    clock.handleTachPulse();
}



void loop() {
    State state = State(clock);
    Serial.println(state.toJson());
    delay(1000);
}

void processMessage(String message) {
  if (message.length() <= 0) return;

  int delimiterIndex = message.indexOf('/');
  String key = message.substring(0, delimiterIndex);
  String value = message.substring(delimiterIndex + 1, message.length());

  Serial.println(key);
  Serial.println(value);
}

#endif
