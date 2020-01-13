#ifndef ClockRunner_ino
#define ClockRunner_ino

#include "Clock.h"

static const int pulseInputPin = 2;
static const int directionInputPin = A0;

static Clock clock = Clock(directionInputPin, 40.0);

static void setup()
{
    Serial.begin(9600);
    Serial.println("Setup");

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

void loop()
{

    Serial.println(clock.isMovingForward() ? "forwards" : "backwards");
    Serial.println(analogRead(A2));
    Serial.println(clock.getTime());
    Serial.println(clock.getRotationsFromStart());
    delay(1000);
}
#endif
