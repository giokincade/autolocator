#include "Arduino.h"
#include "TachSimulator.h"

TachSimulator::TachSimulator(int directionPin, int pulsePin, int playbackRpm=60.0) {
    _secondsFromStart = 0;
    _pulsePin= pulsePin;
    _directionPin = directionPin;
    _secondsPerRotation = 60.0/playbackRpm;
    pinMode(_pulsePin, OUTPUT);
    pinMode(_directionPin, OUTPUT);
}

void TachSimulator::pulseForwards(int seconds) {
    digitalWrite(_directionPin, HIGH);
    pulse(seconds, true);
}

void TachSimulator::pulseBackwards(int seconds) {
    digitalWrite(_directionPin, LOW);
    pulse(seconds, false);
}

int TachSimulator::getSecondsFromStart() {
    return _secondsFromStart;
}

void TachSimulator::pulse(int seconds, bool isForwards) {
    int rotations = seconds / _secondsPerRotation;
    for (int i=0; i < rotations; i++) {
        digitalWrite(_pulsePin, HIGH);
        delay(50);
        digitalWrite(_pulsePin, LOW);
        if (isForwards) {
            _secondsFromStart++;
        } else {
            _secondsFromStart--;
        }
    }
}
