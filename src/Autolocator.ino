#include "Arduino.h"
#include "Clock.h"
#include "State.h"
#include "Socket.h"
#include "Constants.h"

#ifndef Autolocator_ino
#define Autolocator_ino



static Clock clock = Clock(Pins::direction, Constants::playbackRps);

Socket socket;
boolean alreadyConnected = false;


void setup() {
    Serial.begin(9600);
    while(!Serial);

    socket = Socket(Constants::websocketPath, Constants::websocketPort);
    pinMode(Pins::tachPulse, INPUT_PULLUP);
    attachInterrupt(
        digitalPinToInterrupt(Pins::tachPulse),
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
    String json = State(clock).toJson();
    socket.writeMessage(json);
    //Serial.println(json);
    delay(100);
}

void processMessage() {
    String message = socket.readMessage();

    if (message.length() > 0) {
        String json = State(clock).toJson();
        socket.writeMessage(json);
        Serial.println(json);
    }
}

#endif
