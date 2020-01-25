#include "Arduino.h"
#include "Clock.h"


Clock::Clock(int directionPin, double playbackRps) {
    _directionPin = directionPin;
    _rotationsFromStart = 0L;
    _playbackRps = playbackRps;
    pinMode(directionPin, INPUT_PULLUP);
}

bool Clock::isMovingForward() {
    return digitalRead(_directionPin) == LOW;
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

long Clock::getRotationsFromStart() {
    return _rotationsFromStart;
}

double Clock::getSecondsFromStart() {
    return _rotationsFromStart * 1.0 / _playbackRps;
}

String Clock::getTime() {
    double secondsFromStart = getSecondsFromStart();
    int hours = (int) secondsFromStart / 60;
    float seconds = secondsFromStart - (hours * 60);
    int secondsDisplay = (int) seconds;
    int tenthsOfSecond = (int) ((seconds - (secondsDisplay*1.0)) * 100);

    char result[] = "00:00.00";
    sprintf(result, "%02d:%02d.%02d", hours, secondsDisplay, tenthsOfSecond);
    return String(result);
}
