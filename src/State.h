#ifndef State_h
#define State_h

#include "Arduino.h"
#include "Clock.h"

class State {
    public:
       State(Clock clock);
       String toJson();
    private:
       String _time;
       bool _isMovingForwards;
};

#endif
