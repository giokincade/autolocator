#ifndef TachSimulator_h
#define TachSimulator_h

#include "Arduino.h"

class TachSimulator{
    public:
        TachSimulator(int directionPin, int pulsePin, int playbackRpm=60.0);
        void pulseForwards(int seconds);
        void pulseBackwards(int seconds);
        int secondsFromStart();
        int getSecondsFromStart();
    private:
        void pulse(int seconds, bool isForwards);
        int _pulsePin;
        int _directionPin;;
        int _secondsFromStart;
        double _secondsPerRotation;
};

#endif
