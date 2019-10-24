#include "Clock.h"
#include "TachSimulator.h"
#include <ArduinoUnit.h>

const int pulseOutputPin = 3;
const int directionOutputPin = 5;
const int pulseInputPin = 2;
const int directionInputPin = 4;

TachSimulator simulator = TachSimulator(directionOutputPin, pulseOutputPin);
Clock clock = Clock(directionInputPin);

test(clock) {
    simulator.pulseForwards(10);
    simulator.pulseBackwards(5);
    simulator.pulseForwards(20);
    assertEqual(
        simulator.getSecondsFromStart(),
        (int) clock.getSecondsFromStart()
    );
}

void setup()
{
    Serial.begin(9600);
    Serial.println("Setup");
    attachInterrupt(
        digitalPinToInterrupt(pulseInputPin),
        handleTachPulse,
        RISING
    );
}

void handleTachPulse() {
    clock.handleTachPulse();
}

void loop()
{
    Test::run();
}
