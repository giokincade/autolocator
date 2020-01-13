<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Autolocator Websocket</title>
  <style>
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
      background: #cecece;
      margin: 0 auto;
      display: grid;
      grid-template-rows: 2fr 3fr;
      height: 100vh;
    }

    /* COUNTER */
    .Counter {
      background: #1e1e1e;
      color: #ff0000;
      padding: 2rem;
      display: grid;
      grid-template-columns: 1fr;
      grid-template-rows: 1fr 1fr;
      line-height: 1;
      align-items: center;
      justify-items: center;
      background: linear-gradient(#2d2d2d 0%, #000 100%);
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

    /* REMOTE */
    .Remote {
      padding: 2rem;
      position: relative;
      background: linear-gradient(#b5b5b5 0%, #9f9f9f 100%);
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      grid-template-rows: repeat(7, 1fr);
      grid-template-areas:
        "f f f f f f"
        ". . . n n n"
        ". . . n n n"
        ". . . n n n"
        ". . . n n n"
        ". . . . . ."
        "c c c c c c";
      width: 100vw;
    }

    .Remote > div {
      grid-gap: 0.5rem;
    }

    /* FUNCTIONS */
    .Functions {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      grid-template-rows: repeat(2, 1fr);
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
      background: #efefef;
      position: relative;
      /* width: 9rem;
      height: 9rem; */
      background: linear-gradient(#d9d9d9 0%, #d0d0d0 100%);
    }

    .Button .content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .Controls .Button,
    .Button--Recall,
    .Button--Store {
      background: linear-gradient(#e8e8e8 0%, #dfdfdf 100%);
    }

    .Button--active {
      background: linear-gradient(#fff 0%, #e6e6e6 100%) !important;
    }

    .Button--active.Button--Play,
    .Button--active.Button--Stop,
    .Button--active.Button--Rewind,
    .Button--active.Button--FF {
      background: linear-gradient(hsl(50, 90%, 80%) 0%, hsl(50, 90%, 75%) 100%) !important;
    }

    .Button--active.Button--Rec {
      background: linear-gradient(hsl(0, 90%, 60%) 0%, hsl(0, 90%, 65%) 100%) !important;
      color: white;
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
      .Remote > div {
        grid-gap: 1rem;
      }
      .Counter {
        padding: 2rem 4rem 4rem;
        grid-template-columns: 1fr;
        grid-template-rows: 1fr 1fr;
      }

      .Counter__time {
        font-size: 14rem;
      }

      .Remote {
        grid-template-columns: repeat(10, 1fr);
        grid-template-rows: repeat(4, 1fr);
        grid-template-areas:
          "f f f f f f . n n n"
          "f f f f f f . n n n"
          ". . . . . . . n n n"
          "c c c c c c . n n n";
      }
    }

    @media screen and (min-width: 1024px) {
      .Counter {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr;
      }
    }
  </style>
</head>
<body>
  <div class="Container">
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
        <button class="Button Button--Current" data-id="current"><div class="content">Current</div></button>
        <button class="Button Button--Speed" data-id="speed"><div class="content">Speed</div></button>
        <button class="Button Button--Socket" data-id="connet"><div class="content">Connect</div></button>

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
        <button class="Button Button--0" data-id="key0"><div class="content">0</div></button>
        <button class="Button Button--Recall" data-id="recall"><div class="content">Recall</div></button>
      </div>
      <!-- NUMPAD END -->

      <!-- CONTROLS START -->
      <div class="Controls">
        <button class="Button Button--Rec" data-id="rec"><div class="content">Rec</div></button>
        <button class="Button Button--Play" data-id="play"><div class="content">Play</div></button>
        <button class="Button Button--Stop" data-id="stop"><div class="content">Stop</div></button>
        <button class="Button Button--Rewind" data-id="rewind"><div class="content">Rew</div></button>
        <button class="Button Button--FF" data-id="ff"><div class="content">FF</div></button>
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

      ui.socket.innerHTML = 'Connecting';

      socket.onopen = function () {
        sendMessage('connection/1');
        ui.socket.innerHTML = 'Disconnect';
      };

      socket.onclose = function () {
        ui.socket.innerHTML = 'Connect';
        socket.onopen = null;
        socket.onclose = null;
        socket.onmessage = null;
        socket = null;
      }

      socket.onerror = function (error) {
        console.log('WebSocket Error', error);
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

      socket.send(`${message}$`);
    }

    var bindEvents = function () {
      // Window close
      window.addEventListener('onbeforeunload', function() {
        disconnectSocket();
      });

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

      // Buttons events
      ui.buttons.forEach(function(button) {
        ['mousedown', 'touchstart', 'mouseup', 'touchend'].forEach( function(eventType) {
          button.addEventListener(eventType, function(e) {
            e.preventDefault();

            var isStart = ['mousedown', 'touchstart'].find(function(type) { return type === eventType });
            isStart ? button.classList.add('Button--active') : button.classList.remove('Button--active');
            var state = isStart ? '1' : '0';
            var id = e.target.dataset.id;
            sendMessage(`${id}/${state}`);
          }, false);
        });
      });
    }

    document.addEventListener('DOMContentLoaded', function() {
      ui = {
        buttons: document.querySelectorAll('.Button:not(.Button--Socket)'),
        element: function(id) { return document.querySelector(`[data-id="${id}"]`); },
        socket: document.querySelector('.Button--Socket')
      };

      bindEvents();
    }, false);
  </script>
</body>
</html>
