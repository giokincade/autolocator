# Setup

Just run the install script. It should do all the things you need.
```
± ./script/install-dependencies
All done!
```

You'll need to have an arduino connected, but it will complain if it can't find it.

It may have trouble finding the right core to install. It turns out arduino boards and core names are not one-to-one.

# Tach Simulation

You can run a simple simulation of the tach pulse as a form of integration test. You'll need to wire together pins 2+3, and 4+5.

```
± ./script/simulate
Sketch uses 7522 bytes (2%) of program storage space. Maximum is 253952 bytes.
Global variables use 291 bytes (3%) of dynamic memory, leaving 7901 bytes for local variables. Maximum is 8192 bytes.

...
Setup
Test clock passed
Test summary: 1 passed, 0 failed, 0 skipped, out of 1 test(s).
```
