#include "Arduino.h"

namespace Pins {
    const int tachPulse = 2;
    const int direction = 8;

    const int play = A1;
    const int fastForward = A4;
    const int stop = A2;
    const int rewind = A3;
    const int record = A0;

}

namespace Constants {
    const String websocketPath = "autolocator";
    const int websocketPort = 80;
    const double playbackRps = 40.0;

}
