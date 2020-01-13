#include "Arduino.h"
#include "Clock.h"


Clock::Clock(int directionPin, double playbackRps) {
    _directionPin = directionPin;
    _rotationsFromStart = 0;
    _playbackRps = playbackRps;
}

bool Clock::isMovingForward() {
    return analogRead(_directionPin) < 200;
}

bool Clock::isMovingBackwards() {
    return !isMovingBackwards();
}

void Clock::handleTachPulse() {
    if (isMovingForward()) {
        _rotationsFromStart++;
    } else {
        _rotationsFromStart--;
    }
}

int Clock::getRotationsFromStart() {
    return _rotationsFromStart;
}

double Clock::getSecondsFromStart() {
    return _rotationsFromStart * 1.0 / _playbackRps;
}

String Clock::getTime() {
    double secondsFromStart = getSecondsFromStart();
    int hours = (int) secondsFromStart / 60;
    float seconds = secondsFromStart - (hours * 60);
    char result[] = "00:00.00";
    char secondsBuffer[] = "00.00";
    dtostrf(seconds, 4, 2, secondsBuffer);
    sprintf(result, "%02d:%s", hours, secondsBuffer);
    return String(result);
}
