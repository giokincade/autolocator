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
    processMessage(socket.read());
}

void processMessage(String message) {
    if (message.length() <= 0) return;
    Serial.println(message);
    State state = State(clock);
    String json = state.toJson();
    socket.write(json.c_str());
    Serial.println(json);
}
#endif
