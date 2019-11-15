#include "Arduino.h"
#include "Clock.h"


Clock::Clock(int directionPin, int playbackRps=180.0) {
    _directionPin = directionPin;
    _rotationsFromStart = 0;
    _playbackRps = playbackRps;
    pinMode(_directionPin, INPUT);
}

bool Clock::isMovingForward() {
    //return digitalRead(_directionPin) == LOW;
    return true;
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
    int secondsFromStart = (int) getSecondsFromStart();
    int hours = secondsFromStart / 60;
    int seconds = secondsFromStart % 60;
    char result[] = "00:00";
    sprintf(result, "%02d:%02d", hours, seconds);
    return String(result);
}
