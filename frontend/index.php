<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Autolocator Websocket</title>
  <style>
    :root {
      --color_backgrond: hsl(0, 0%, 0%);
      --color_backgrond--alt: hsl(0, 0%, 15%);
      --color_counter: hsl(5, 90%, 50%);
      --color_button: hsl(0, 0%, 10%);
      --color_button--active: hsl(0, 0%, 12%);
      --color-text: hsl(5, 90%, 95%);
      --color-controls: hsl(45, 90%, 50%);
      --color-blue: hsl(220, 90%, 40%);
      --padding--small: 1rem;
      --padding--medium: 2rem;
      --padding--large: 4rem;
    }

    @font-face {
      font-family: 'Segment';
      src: url('Seven-Segment.ttf');
    }

    * {
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
    }

    html {
      font-size: 62.5%;
      margin: 0;
      padding: 0;
    }

    body {
      margin: 0;
      padding: 0;
      font-size: 1.8rem;
      width: 100vw;
      height: 100vh;
      overflow: hidden;
      font-weight: Helvetica;
    }

    .Container {
      margin: 0 auto;
      display: grid;
      grid-template-rows: 2fr 3fr;
      height: 100vh;
      position: relative;
    }

    /* COUNTER */
    .Counter {
      color: var(--color_counter);
      padding: var(--padding--medium);
      display: grid;
      grid-template-columns: 1fr;
      grid-template-rows: 1fr 1fr;
      line-height: 1;
      align-items: center;
      justify-items: center;
      position: relative;
      background: linear-gradient(var(--color_backgrond--alt) 0%, var(--color_backgrond) 100%);
      font-family: 'Segment';
      width: 100vw;
    }

    .Counter__section {
      display: grid;
      align-self: start;
      min-width: 40rem;
    }

    .Counter__time,
    .Counter__indicator {
      display: block;
    }

    .Counter__time {
      font-size: 10rem;
    }

    .Counter__indicator {
      font-size: 3rem;
      min-height: 3rem;
    }

    .Socket {
      position: absolute;
      top: var(--padding--small);
      right: var(--padding--small);
      text-transform: uppercase;
      font-family: 'Segment';
      font-size: 1.6rem;
      color: var(--color_counter);
      z-index: 1;
    }

    /* REMOTE */
    .Remote {
      position: relative;
      background: linear-gradient(var(--color_backgrond) 0%, var(--color_backgrond--alt) 100%);
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      grid-template-rows: repeat(6, 1fr);
      grid-template-areas:
        "f f f f f"
        ". . n n n"
        ". . n n n"
        ". . n n n"
        ". . n n n"
        "c c c c c";
      width: 100vw;
      padding: var(--padding--small);
      grid-gap: var(--padding--small);
    }

    .Remote > div {
      grid-gap: var(--padding--small);
    }

    /* FUNCTIONS */
    .Functions {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      grid-template-rows: repeat(1, 1fr);
      grid-area: f;
    }

    /* NUMPAD */
    .Numpad {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-template-rows: repeat(4, 1fr);
      grid-area: n;
    }

    /* BUTTONS */
    .Button {
      margin: 0;
      padding: 0;
      border: 1px solid #555;
      position: relative;
      color: var(--color-text);
      font-size: 1.6rem;
      font-weight: 100;
      text-transform: uppercase;
      letter-spacing: 2px;
      /* background: linear-gradient(#d9d9d9 0%, #d0d0d0 100%); */
      background: transparent;
      border-bottom: 4px solid;
      border-bottom-color: transparent;
    }

    .Button .content {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: grid;
      align-content: center;
      justify-content: center;
    }

    .Controls .Button,
    .Button--Recall,
    .Button--Store {
      /* background: linear-gradient(#e8e8e8 0%, #dfdfdf 100%); */
    }

    .Button:active,
    .Button--active {
      border-bottom-color: var(--color-text);
    }

    .Button--active.Button--Play,
    .Button--active.Button--Rewind,
    .Button--active.Button--FF {
      border-bottom-color: var(--color-controls);
    }

    .Button--active.Button--Stop {
      border-bottom-color: var(--color-blue);
    }

    .Button--active.Button--Rec {
      border-bottom-color: var(--color_counter);
    }

    /* CONTROLS */
    .Controls {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      grid-area: c;
    }

    .Controls .Button {
      /* width: 12rem;
      height: 12rem; */
    }

    /* SOCKET CONNECTION */
    .Socket {

    }

    @media screen and (min-width: 667px) {
      .Container {
        grid-template-rows: 1fr 3fr;
      }

      .Counter {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr;
      }

      .Counter__time {
        font-size: 8rem;
      }
    }

    @media screen and (min-width: 768px) {
      .Remote {
        padding: var(--padding--medium);
        grid-gap: var(--padding--medium);
      }

      .Remote > div {
        grid-gap: var(--padding--medium);
      }

      .Counter {
        padding: var(--padding--large);
        grid-template-columns: 1fr;
        grid-template-rows: 1fr 1fr;
      }

      .Socket {
        top: var(--padding--medium);
        right: var(--padding--medium);
      }

      .Counter__time {
        font-size: 14rem;
      }

      .Remote {
        grid-template-columns: repeat(8, 1fr);
        grid-template-rows: repeat(4, 1fr);
        grid-template-areas:
          "f f f f f n n n"
          ". . . . . n n n"
          ". . . . . n n n"
          "c c c c c n n n";
      }
    }

    @media screen and (min-width: 1024px) {
      .Remote {
        padding: var(--padding--large);
        grid-gap: var(--padding--large);
      }

      .Remote > div {
        grid-gap: var(--padding--large);
      }

      .Counter {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr;
      }

      .Socket {
      }
    }
  </style>
</head>
<body>
  <div class="Container">
    <span class="Socket" data-id="socket"></span>

    <!-- COUNTER START -->
    <div class="Counter">
      <div class="Counter__section">
        <span class="Counter__time" data-id="playhead_time">09:47.2</span>
        <span class="Counter__indicator" data-id="playhead_status"> </span>
      </div>
      <div class="Counter__section">
        <span class="Counter__time" data-id="locate_time">00:00.0</span>
        <span class="Counter__indicator" data-id="locate_status"></span>
      </div>
    </div>
    <!-- COUNTER END -->

    <div class="Remote">
      <!-- FUNCTIONS START -->
      <div class="Functions">
        <button class="Button Button--Reset Command" data-id="reset" data-cmd="reset/1"><div class="content">Reset</div></button>
        <button class="Button Button--Rtz Command" data-id="rtz" data-cmd="locate/0"><div class="content">RTZ</div></button>
        <button class="Button Button--Speed Command" data-id="speed"><div class="content">Speed</div></button>
        <button class="Button Button--Current" data-id="current"><div class="content">CRNT</div></button>
        <button class="Button Button--Locate Command" data-id="locate"><div class="content">Loc</div></button>


        <!-- <button class="Button Button--AutoPunchOn" data-id="autopunch_on"><div class="content">AP On</div></button>
        <button class="Button Button--AutoPunchIn" data-id="autopunch_in"><div class="content">AP In</div></button>
        <button class="Button Button--AutoPunchOut" data-id="autopunch_out"><div class="content">AP Out</div></button> -->
        <!-- <button class="Button"><div class="content"></div></button>
        <button class="Button"><div class="content"></div></button>
        <button class="Button"><div class="content"></div></button>
        <button class="Button"><div class="content"></div></button>
        <button class="Button"><div class="content"></div></button>
        <button class="Button"><div class="content"></div></button> -->
      </div>
      <!-- FUNCTIONS END -->

      <!-- NUMPAD START -->
      <div class="Numpad">
        <button class="Button Button--num" data-id="9"><div class="content">9</div></button>
        <button class="Button Button--num" data-id="8"><div class="content">8</div></button>
        <button class="Button Button--num" data-id="7"><div class="content">7</div></button>
        <button class="Button Button--num" data-id="6"><div class="content">6</div></button>
        <button class="Button Button--num" data-id="5"><div class="content">5</div></button>
        <button class="Button Button--num" data-id="4"><div class="content">4</div></button>
        <button class="Button Button--num" data-id="3"><div class="content">3</div></button>
        <button class="Button Button--num" data-id="2"><div class="content">2</div></button>
        <button class="Button Button--num" data-id="1"><div class="content">1</div></button>
        <button class="Button Button--Store" data-id="store"><div class="content">Store</div></button>
        <button class="Button Button--num" data-id="0"><div class="content">0</div></button>
        <button class="Button Button--Recall" data-id="recall"><div class="content">Recall</div></button>
      </div>
      <!-- NUMPAD END -->

      <!-- CONTROLS START -->
      <div class="Controls">
        <button class="Button Button--Rec Command" data-id="rec" data-cmd="rec/1"><div class="content">Rec</div></button>
        <button class="Button Button--Play Command" data-id="play" data-cmd="play/1"><div class="content">Play</div></button>
        <button class="Button Button--Stop Command" data-id="stop" data-cmd="stop/1"><div class="content">Stop</div></button>
        <button class="Button Button--Rewind Command" data-id="rewind" data-cmd="rewind/1"><div class="content">Rew</div></button>
        <button class="Button Button--FF Command" data-id="ff" data-cmd="ff/1"><div class="content">FF</div></button>
      </div>
      <!-- CONTROLS END -->
    </div>
  </div>
  <script>
    const isPhp = parseInt('<?echo "1"; ?>') === 1;
    const numKeyStates = {
      INPUT: 'input',
      RECALL: 'recall',
      STORE: 'store'
    }
    let ui;
    let socket;
    let state = {
      controls: {
        rec: false,
        play: false,
        stop: false,
        rewind: false,
        ff: false
      },
      playhead_time: false,
      locate_time: false,
      speed: true
    };
    let locate = [0, 1, 0, 0, 0];
    let locateIndex = 0;

    let numKeyState = numKeyStates.INPUT;
    let locateAddress = [];
    let locateAddressIndex = 0;

    const connectSocket = () => {
      if (isPhp) {
        const host = '<?echo _SERVER("HTTP_HOST")?>';

        if ((navigator.platform.indexOf("Win") != -1) && (host.charAt(0) == "[")) {
          // network resource identifier to UNC path name conversion
          host = host.replace(/[\[\]]/g, '');
          host = host.replace(/:/g, "-");
          host += ".ipv6-literal.net";
        }

        socket = new WebSocket(`ws://${host}/autolocator`, "text.phpoc");
      } else {
        socket = new WebSocket('ws://localhost:9030', 'echo-protocol');
      }

      setSocketStatus('Connecting');

      socket.onopen = () => {
        sendMessage('connection/1');
        setSocketStatus('Connected');
      };

      socket.onclose = () => {
        setSocketStatus('Connecting');
        socket.onopen = null;
        socket.onclose = null;
        socket.onmessage = null;
        socket = null;
      }

      socket.onerror = error => {
        console.log('WebSocket Error', error);
        connectSocket();
      };

      socket.onmessage = e => {
        if (e.data.indexOf('$') > -1) {
          const nextState = e.data.substring(0, e.data.length - 1);
          try {
            const parsedState = JSON.parse(nextState);
            updateUiFromState(parsedState);
          } catch (e) {
            console.log(e);
            updateUiFromState(nextState);
          }
        }
      };
    }

    const disconnectSocket = () => {
      sendMessage('connection/0');
      socket && socket.close();
    }

    const recieveMessage = message => {
      if (message.indexOf('/') > -1) {
        const parts = message.split('/');
        const element = ui.element(parts[0]);
        updateElement(parts[1]);
      }
    }

    const sendMessage = message => {
      if (!socket) return;
      console.log('Sending', message);
      socket.send(`${message}$`);
    }

    const updateUiFromState = nextState => {
      if (nextState) {
        state = nextState;
      }

      updateControls();
      updateLocateTime();
      updatePlayhead();
      updatePlayheadStatus();
      updateSpeed();
    }

    const updateControls = () => {
      if (!state.controls) return;

      Object.keys(state.controls).forEach(key => {
        const element = ui.element(key);
        const isActive = state.controls[key];

        if (element) {
          element.classList.remove('Button--active');
          isActive && element.classList.add('Button--active');
        }
      });
    }

    const updateLocateTime = () => {
      if (!('locate_time' in state)) return;
      setTime(ui.locateTime, state.locate_time);
      state.locate_time = false;
      locate = timeToArray(state.locate_time);
    }

    const updatePlayhead = () => {
      if (!('playhead_time' in state)) return;
      setTime(ui.playheadTime, state.playhead_time);
    }

    const updatePlayheadStatus = () => {
      if (!state.controls) return;

      let status = '';
      const { rec, play, stop, rewind, ff } = state.controls;

      if (!rec && !play && stop && !rewind && !ff) {
        status = 'Stopped';
      }

      if (rec && play && !stop && !rewind && !ff) {
        status = 'Recording';
      }

      if (!rec && play && !stop && !rewind && !ff) {
        status = 'Playing';
      }

      if (!rec && !play && !stop && rewind && !ff) {
        status = 'Rewinding';
      }

      if (!rec && !play && !stop && !rewind && ff) {
        status = 'Fast Forwarding';
      }

      updateElement(ui.playheadStatus, status);
    }

    const updateLocateFromArray = () => {
      if ('locate_time' in state && !!state.locate_time) return;

      const element = ui.locateTime;

      const minutes = locate.slice(0, 2).join('');
      const seconds = locate.slice(2, 4).join('');
      const decimal = locate.slice(4);

      const value = formatTimeString(minutes, seconds, decimal);

      updateElement(element, value);

      // get locate time as int
      const locateTime = timeFromArray(locate);

      // update locate commands
      updateLocateCommands(locateTime);
    }

    const updateLocateCommands = time => {
      // update store locate command
      const storeElement = ui.element('store');
      const storeCommand = `store/${time}`;
      updateElementCommand(storeElement, storeCommand);

      // update locate command
      const locateElement = ui.element('locate');
      const locateCommand = `locate/${time}`;
      updateElementCommand(locateElement, locateCommand);
    }

    const updateSpeed = () => {
      if (!('speed' in state)) return;

      const element = ui.element('speed');
      const speedContent = state.speed ? 'SPEED (HIGH)' : 'SPEED (LOW)';
      const speedCommand = state.speed ? 'speed/0' : 'speed/1';

      updateElement(element, speedContent);
      updateElementCommand(element, speedCommand);
    }

    const bindEvents = () => {
      // Disconnect from socket on window/tab close
      window.addEventListener('onbeforeunload', function() {
        disconnectSocket();
      });

      // Command button events
      ui.commandButtons.forEach(button => {
        ['touchstart', 'mousedown'].forEach( eventType => {
          button.addEventListener(eventType, e => {
            e.preventDefault();
            const element = getButtonElementFromEvent(e);
            sendCommandFromElement(element);

            // reset locateIndex and address
            locateIndex = 0;
            resetLocateAddress();
          }, false);
        });
      });

      // Num button events
      ui.numButtons.forEach(button => {
        ['touchstart', 'mousedown'].forEach( eventType => {
          button.addEventListener(eventType, e => {
            e.preventDefault();
            const element = getButtonElementFromEvent(e);
            handleNumButton(element);
          }, false);
        });
      });

      // Current button events
      ['touchstart', 'mousedown'].forEach( eventType => {
        ui.currentButton.addEventListener(eventType, e => {
          e.preventDefault();
          handleCurrentButton();
          resetLocateAddress();
        }, false);
      });

      // Store button events
      ['touchstart', 'mousedown'].forEach( eventType => {
        ui.storeButton.addEventListener(eventType, e => {
          e.preventDefault();
          handleStoreButton();
        }, false);
      });

      // Recall button events
      ['touchstart', 'mousedown'].forEach( eventType => {
        ui.recallButton.addEventListener(eventType, e => {
          e.preventDefault();
          handleRecallButton();
        }, false);
      });
    }

    const getButtonElementFromEvent = e => e.target.className.includes('Button') ? e.target : e.target.parentNode;

    const sendCommandFromElement = element => {
      if (element && element.dataset) {
        const command = element.dataset.cmd;
        command && sendMessage(command);
      }
    }

    const handleNumButton = element => {
      if (!element) return;

      const digit = parseInt(element.dataset.id);

      const { INPUT, RECALL, STORE } = numKeyStates;

      if (numKeyState === INPUT) {
        resetLocateAddress();
        handleNumInput(digit);
      }

      if (numKeyState === RECALL) {
        handleStoreAndRecall(digit);
      }

      if (numKeyState === STORE) {
        handleStoreAndRecall(digit);
      }
    }

    const handleNumInput = digit => {
      // add digit array at current index
      locate[locateIndex] = digit;

      // update index
      locateIndex = locateIndex === 4 ? 0 : locateIndex + 1;

      // update locate html
      updateLocateFromArray();
    }

    handleStoreAndRecall = digit => {
      // add digit array at current index
      locateAddress[locateAddressIndex] = digit;

      // update index
      locateAddressIndex++;

      // update locate html
      updateLocateAddressFromArray();

      if (locateAddress.length === 2) {
        // send command
        const address = locateAddress.join('');
        const time = numKeyState === numKeyStates.STORE ? `,${timeFromArray(locate)}` : '';
        const command = `${numKeyState}/${address}${time}`;
        sendMessage(command);

        // reset
        resetLocateAddress();
      }
    }

    const handleCurrentButton = () => {
      if (!('playhead_time' in state)) return;

      const time = state.playhead_time;

      // set locate html
      setTime(ui.locateTime, time);

      // set locate button commands
      updateLocateCommands(time);

      // update locate time array
      locate = timeToArray(time);

      // reset locate index
      locateIndex = 0;
    }

    const handleStoreButton = () => {
      numKeyState = numKeyState === numKeyStates.STORE ? numKeyStates.INPUT : numKeyStates.STORE;

      ui.recallButton.classList.remove('Button--active');
      ui.storeButton.classList.remove('Button--active');
      updateElement(ui.locateStatus, '');

      if (numKeyState === numKeyStates.STORE) {
        ui.storeButton.classList.add('Button--active');
        updateElement(ui.locateStatus, `STORING`);
      } else {
        resetLocateAddress();
      }
    }

    const handleRecallButton = () => {
      numKeyState = numKeyState === numKeyStates.RECALL ? numKeyStates.INPUT : numKeyStates.RECALL;

      ui.recallButton.classList.remove('Button--active');
      ui.storeButton.classList.remove('Button--active');
      updateElement(ui.locateStatus, '');

      if (numKeyState === numKeyStates.RECALL) {
        ui.recallButton.classList.add('Button--active');
        updateElement(ui.locateStatus, `RECALLING`);
      } else {
        resetLocateAddress();
      }
    }

    const updateLocateAddressFromArray = () => {
      const { RECALL, STORE } = numKeyStates;
      const address = locateAddress.join('');
      const text = numKeyState === RECALL ? 'RECALLING' : 'STORING';

      updateElement(ui.locateStatus, `${text} ${address}`);
    }

    const resetLocateAddress = () => {
      ui.recallButton.classList.remove('Button--active');
      ui.storeButton.classList.remove('Button--active');
      setTimeout(() => { updateElement(ui.locateStatus, ''); }, 100);
      locateAddressIndex = 0;
      locateAddress = [];
      numKeyState = numKeyStates.INPUT;
    }

    const setSocketStatus = text => {
      updateElement(ui.socket, text);
    }

    const setTime = (element, time) => {
      if (!parseInt(time) && time != 0) return;
      updateElement(element, formatTime(time));
    }

    const timeFromArray = timeArray => {
      if (!timeArray || timeArray.length > 5) return;

      const minutes = parseInt(timeArray.slice(0, 2).join(''));
      const seconds = parseInt(timeArray.slice(2, 4).join(''));
      const decimal = parseInt(timeArray.slice(4));

      return minutes * 60 + seconds +  decimal / 10;
    }

    const timeToArray = time => {
      const { minutes, seconds, decimal } = partsFromTime(time);

      const minuteArray = padNumber(minutes).split('');
      const secondsArray = padNumber(seconds).split('');
      const decimalArray = [decimal];

      return [].concat(minuteArray, secondsArray, decimalArray).map(n => parseInt(n));
    }

    const formatTime = time => {
      const { minutes, seconds, decimal } = partsFromTime(time);

      return formatTimeString(padNumber(minutes), padNumber(seconds), decimal);
    }

    const formatTimeString = (minutes, seconds, decimal) => {
      return `${minutes}:${seconds}.${decimal}`;
    }

    const partsFromTime = time => ({
      minutes:  Math.floor(time / 60),
      seconds:  Math.floor(time % 60),
      decimal:  (time % 1).toFixed(1).substring(2)
    })

    const padNumber = number => {
      const s = `0${number}`;
      return s.substr(s.length - 2);
    }

    const updateElement = (element, html) => {
      if (!element) return;
      element.innerHTML = html;
    }

    const updateElementCommand = (element, command) => {
      if (!element || !command) return;
      element.dataset.cmd = command;
    }

    document.addEventListener('DOMContentLoaded', () => {
      const getElement = id => document.querySelector(`[data-id="${id}"]`);

      ui = {
        commandButtons: document.querySelectorAll('.Command'),
        currentButton: document.querySelector('.Button--Current'),
        element: id => getElement(id),
        locateTime: getElement('locate_time'),
        locateStatus: getElement('locate_status'),
        numButtons: document.querySelectorAll('.Button--num'),
        playheadTime: getElement('playhead_time'),
        playheadStatus: getElement('playhead_status'),
        recallButton: getElement('recall'),
        socket: document.querySelector('.Socket'),
        storeButton: getElement('store')
      };

      bindEvents();

      updateLocateFromArray();

      updateUiFromState();

      if (!socket) {
        connectSocket();
      }

    }, false);
  </script>
</body>
</html>
