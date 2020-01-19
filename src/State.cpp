#include "Arduino.h"
#include "State.h"
#include "Clock.h"
#include <ArduinoJson.h>

const size_t _JSON_SIZE = JSON_OBJECT_SIZE(2) + 31;

State::State(Clock clock) {
    _time = clock.getTime();
    _isMovingForward = clock.isMovingForward()
}

State::toJson() {
    StaticJsonDocument<_JSON_SIZE> doc;
    doc["time"] = _time;
    doc["isMovingForwards"] = _isMovingForwards;

    String output = "";
    serializeJson(doc, output);
    return output;
}
