#include "Arduino.h"
#include "State.h"
#include "Clock.h"
#include <ArduinoJson.h>

const size_t _JSON_SIZE = JSON_OBJECT_SIZE(2) + 31;

State::State(Clock clock) {
    _time = clock.getTime();
    _isMovingForwards = clock.isMovingForward();
}

String State::toJson() {
    StaticJsonDocument<_JSON_SIZE> doc;
    doc["playhead_time"] = _time;
    doc["isMovingForwards"] = _isMovingForwards;

    String output = "";
    serializeJson(doc, output);
    return output;
}
