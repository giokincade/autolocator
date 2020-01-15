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

    .Counter__time,
    .Counter__indicator {
      display: block;
    }

    .Counter__time {
      font-size: 10rem;
    }

    .Counter__indicator {
      font-size: 3rem;
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
      border: none;
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

    .Button:active {
      background: var(--color_button--active);
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

    .Button--active {
      /* background: linear-gradient(var(--color_button--active) 0%, var(--color_button--active) 100%) !important; */
      border-bottom-color: var(--color-text);
    }

    .Button--active.Button--Play,
    .Button--active.Button--Stop,
    .Button--active.Button--Rewind,
    .Button--active.Button--FF {

    }

    .Button--active.Button--Rec {


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
        <span class="Counter__indicator" data-id="playhead_status">Playing</span>
      </div>
      <div class="Counter__section">
        <span class="Counter__time" data-id="locate_time">09:03.4</span>
        <span class="Counter__indicator" data-id="locate_status">Locate Point 24</span>
      </div>
    </div>
    <!-- COUNTER END -->

    <div class="Remote">
      <!-- FUNCTIONS START -->
      <div class="Functions">
        <button class="Button Button--Reset" data-id="reset"><div class="content">Reset</div></button>
        <button class="Button Button--Rtz" data-id="rtz"><div class="content">RTZ</div></button>
        <button class="Button Button--Locate" data-id="locate"><div class="content">Loc</div></button>
        <button class="Button Button--Current" data-id="current"><div class="content">CRNT</div></button>
        <button class="Button Button--Speed" data-id="speed"><div class="content">Speed</div></button>

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
        <button class="Button Button--9" data-id="key09"><div class="content">9</div></button>
        <button class="Button Button--8" data-id="key08"><div class="content">8</div></button>
        <button class="Button Button--7" data-id="key07"><div class="content">7</div></button>
        <button class="Button Button--6" data-id="key06"><div class="content">6</div></button>
        <button class="Button Button--5" data-id="key05"><div class="content">5</div></button>
        <button class="Button Button--4" data-id="key04"><div class="content">4</div></button>
        <button class="Button Button--3" data-id="key03"><div class="content">3</div></button>
        <button class="Button Button--2" data-id="key02"><div class="content">2</div></button>
        <button class="Button Button--1" data-id="key01"><div class="content">1</div></button>
        <button class="Button Button--Store" data-id="store"><div class="content">Store</div></button>
        <button class="Button Button--0" data-id="key00"><div class="content">0</div></button>
        <button class="Button Button--Recall" data-id="recall"><div class="content">Recall</div></button>
      </div>
      <!-- NUMPAD END -->

      <!-- CONTROLS START -->
      <div class="Controls">
        <button class="Button Button--Rec" data-id="rec" data-cmd="rec/1"><div class="content">Rec</div></button>
        <button class="Button Button--Play" data-id="play" data-cmd="play/1"><div class="content">Play</div></button>
        <button class="Button Button--Stop" data-id="stop" data-cmd="stop/1"><div class="content">Stop</div></button>
        <button class="Button Button--Rewind" data-id="rewind" data-cmd="rewind/1"><div class="content">Rew</div></button>
        <button class="Button Button--FF" data-id="ff" data-cmd="ff/1"><div class="content">FF</div></button>
      </div>
      <!-- CONTROLS END -->
    </div>
  </div>
  <script>
    var isPhp = parseInt('<?echo "1"; ?>') === 1;
    var ui;
    var socket;

    var connectSocket = function () {
      if (isPhp) {
        var host = '<?echo _SERVER("HTTP_HOST")?>';

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

      socket.onopen = function () {
        sendMessage('connection/1');
        setSocketStatus('Connected');
      };

      socket.onclose = function () {
        setSocketStatus('Connecting');
        socket.onopen = null;
        socket.onclose = null;
        socket.onmessage = null;
        socket = null;
      }

      socket.onerror = function (error) {
        console.log('WebSocket Error', error);
        connectSocket();
      };

      socket.onmessage = function (e) {
        if (e.data.indexOf('$') > -1) {
          var message = e.data.substring(0, e.data.length - 1);
          recieveMessage(message);
        }
      };
    }

    var disconnectSocket = function() {
      sendMessage('connection/0');
      socket && socket.close();
    }

    var recieveMessage = function (message) {
      if (message.indexOf('/') > -1) {
        var parts = message.split('/');
        var element = ui.element(parts[0]);
        if (element) {
          element.innerHTML = parts[1];
        }
      }
    }

    var sendMessage = function (message) {
      if (!socket) return;
      console.log('Sending', message);
      socket.send(`${message}$`);
    }

    var bindEvents = function () {
      // Window close
      window.addEventListener('onbeforeunload', function() {
        disconnectSocket();
      });

      /*
      // Socket connection events
      ['mousedown', 'touchstart'].forEach(function(eventType) {
        ui.socket.addEventListener(eventType, function(e) {
          e.preventDefault();

          if (!socket) {
            connectSocket();
          } else {
            disconnectSocket();
          }
        });
      });
      */

      // Buttons events
      ui.controls.forEach(function(button) {
        ['touchstart', 'mousedown'].forEach( function(eventType) {
          button.addEventListener(eventType, function(e) {
            e.preventDefault();
            sendCommandFromElement(e.target.parentNode);
          }, false);
        });
      });
    }

    var sendCommandFromElement = function(element) {
      if (element && element.dataset) {
        var command = element.dataset.cmd;
        command && sendMessage(command);
      }
    }

    var setSocketStatus = function(text) {
      if (ui.socket) {
        ui.socket.innerHTML = text;
      }
    }

    document.addEventListener('DOMContentLoaded', function() {
      ui = {
        buttons: document.querySelectorAll('.Button:not(.Button--Socket)'),
        controls: document.querySelectorAll('.Controls .Button'),
        element: function(id) { return document.querySelector(`[data-id="${id}"]`); },
        socket: document.querySelector('.Socket')
      };

      bindEvents();

      if (!socket) {
        connectSocket();
      }
    }, false);
  </script>
</body>
</html>
