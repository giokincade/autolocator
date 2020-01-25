#include "Arduino.h"
#include "Clock.h"
#include "State.h"
#include "Socket.h"
#include "Constants.h"
#include "Control.h"

#ifndef Autolocator_ino
#define Autolocator_ino



static Clock clock = Clock(Pins::direction, Constants::playbackRps);

Socket socket;
Control control;
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
    String message = socket.readMessage();

    if (message.length() > 0) {
        Serial.println(message);
        if (message.startsWith("reset")) {
            clock.reset();
        } else {
            control.runCommandFromText(message);
        }
    } else {
        String json = State(clock).toJson();
        socket.writeMessage(json);
    }

    delay(100);
}

#endif
