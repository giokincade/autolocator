#ifndef Simulate_ino
#define Simulate_ino

#include "Clock.h"
#include "TachSimulator.h"
#include <ArduinoUnit.h>

const static int pulseOutputPin = 3;
const static int directionOutputPin = 5;
const static int pulseInputPin = 2;
const static int directionInputPin = 4;

static TachSimulator simulator = TachSimulator(directionOutputPin, pulseOutputPin);
static Clock clock = Clock(directionInputPin);

test(clock) {
    simulator.pulseForwards(10);
    simulator.pulseBackwards(5);
    simulator.pulseForwards(20);
    assertEqual(
        simulator.getSecondsFromStart(),
        (int) clock.getSecondsFromStart()
    );
    Serial.println(clock.getTime());
    assertEqual(
        String("00:25"),
        clock.getTime()
    );
}

static void setup()
{
    Serial.begin(9600);
    Serial.println("Setup");

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
    Test::run();
}

#endif
