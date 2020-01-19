#include "Arduino.h"
#include "Clock.h"
#include "State.h"
#include <Phpoc.h>

#ifndef Autolocator_ino
#define Autolocator_ino


static const int pulseInputPin = 2;
static const int directionInputPin = A0;

static Clock clock = Clock(directionInputPin, 40.0);

PhpocServer server(80);
boolean alreadyConnected = false;


void setup() {
    Serial.begin(9600);
    while(!Serial);

    Phpoc.begin(PF_LOG_SPI | PF_LOG_NET);
    server.beginWebSocket("autolocator");

    Serial.print("Chat server address : ");
    Serial.println(Phpoc.localIP());

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
    processMessage();
}

void processMessage() {
    PhpocClient client = server.available();

    if (client) {
        Serial.println("boom");
        if (!alreadyConnected) {
            // clear out the transmission buffer:
            client.flush();
            Serial.println("We have a new client");
            alreadyConnected = true;
        }

        if (client.available() > 0) {
            // read the bytes incoming from the client:
            while(client.read() > -1);
            String json = State(clock).toJson();
            char* jsonCstr = json.c_str();
            server.write(jsonCstr, json.length());
            // echo the bytes to the server as well:
            Serial.write(jsonCstr);
        }
    }
}

#endif
