#ifndef Clock_h
#define Clock_h

#include "Arduino.h"

class Clock {
  public:
    Clock(int directionPin, double playbackRps=90.0);
    void handleTachPulse();
    int getRotationsFromStart();
    bool isMovingForward();
    bool isMovingBackwards();
    double getSecondsFromStart();
    String getTime();
  private:
    int _directionPin;
    int volatile _rotationsFromStart;
    double _playbackRps;
};

#endif
