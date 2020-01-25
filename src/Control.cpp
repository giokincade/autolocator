#import "Arduino.h"
#import "Control.h"
#import "Constants.h"

Control::Control() {
    pinMode(Pins::play, OUTPUT);
    digitalWrite(Pins::play, HIGH);
    pinMode(Pins::fastForward, OUTPUT);
    digitalWrite(Pins::fastForward, HIGH);
    pinMode(Pins::stop, OUTPUT);
    digitalWrite(Pins::stop, HIGH);
    pinMode(Pins::rewind, OUTPUT);
    digitalWrite(Pins::rewind, HIGH);
    pinMode(Pins::record, OUTPUT);
    digitalWrite(Pins::record, HIGH);
}


void Control::play() {
    pulsePin(Pins::play);
}

void Control::record() {
    pulsePin(Pins::record);
}

void Control::stop() {
    pulsePin(Pins::stop);
}

void Control::rewind() {
    pulsePin(Pins::rewind);
}

void Control::fastForward() {
    pulsePin(Pins::fastForward);
}

void Control::pulsePin(int pin) {
    digitalWrite(pin, LOW);
    delay(50);
    digitalWrite(pin, HIGH);
}

void Control::runCommandFromText(String command) {
    if (command.startsWith("play")) {
        play();
    } else if (command.startsWith("rewind")) {
        rewind();
    } else if (command.startsWith("stop")) {
        stop();
    } else if (command.startsWith("fast_forward")) {
        fastForward();
    } else if (command.startsWith("record")) {
        record();
    }
}

