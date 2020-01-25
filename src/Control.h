


class Control {
    public:
        Control();
        void play();
        void fastForward();
        void rewind();
        void stop();
        void record();
        void runCommandFromText(String command);
    private:
        void pulsePin(int pin);
};
