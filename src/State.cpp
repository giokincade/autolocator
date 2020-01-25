#include "Arduino.h"
#include "State.h"
#include "Clock.h"
#include <ArduinoJson.h>

const size_t _JSON_SIZE = JSON_OBJECT_SIZE(3) + 31;

State::State(Clock clock) {
    _time = clock.getTime();
    _secondsFromStart = clock.getSecondsFromStart();
    _isMovingForwards = clock.isMovingForward();
}

String State::toJson() {
    StaticJsonDocument<_JSON_SIZE> doc;
    doc["playhead_time"] = _secondsFromStart;
    doc["playhead_time_pretty"] = _time;
    doc["isMovingForwards"] = _isMovingForwards;

    String output = "";
    serializeJson(doc, output);
    return output;
}
