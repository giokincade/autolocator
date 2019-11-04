#include "Arduino.h"
#include "Clock.h"


Clock::Clock(int directionPin, int playbackRpm=60.0) {
    _directionPin = directionPin;
    _rotationsFromStart = 0;
    _playbackRpm = playbackRpm;
    pinMode(_directionPin, INPUT);
}

bool Clock::isMovingForward() {
    return digitalRead(_directionPin) == HIGH;
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

double Clock::getSecondsFromStart() {
    return _rotationsFromStart * 1.0 / _playbackRpm * 60.0;
}

String Clock::getTime() {
    int secondsFromStart = (int) getSecondsFromStart();
    int hours = secondsFromStart / 60;
    int seconds = secondsFromStart % 60;
    char result[] = "00:00";
    sprintf(result, "%02d:%02d", hours, seconds);
    return String(result);
}
