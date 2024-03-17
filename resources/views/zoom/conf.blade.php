@php
  header('Cross-Origin-Opener-Policy: same-origin');
  header('Cross-Origin-Embedder-Policy: require-corp');
@endphp

<!DOCTYPE html>

<head>
    <title>Cargando sala...</title>
    <meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/2.9.7/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/2.9.7/css/react-select.css" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

</head>

<body>

    <form class="navbar-form navbar-right" id="meeting_form">
        <input type="hidden" id="display_name" name="display_name" value="{{ Auth::user()->nombres.' '.Auth::user()->apellidos }}">
        <input type="hidden" id="meeting_number" name="meeting_number" value="{{ $laSala }}">
        <input type="hidden" id="meeting_pwd" name="meeting_pwd" value="">
        <input type="hidden" id="meeting_email" name="meeting_email" value="{{ Auth::user()->email }}">
        <input type="hidden" id="meeting_role" value="{{ $rolAsignado }}">
        <input type="hidden" id="meeting_china" value="0">
        <input type="hidden" id="meeting_lang" value="es-ES">
        <input type="hidden" value="" id="copy_link_value" />

    </form>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

    <script src="https://source.zoom.us/2.9.7/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/2.9.7/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/2.9.7/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/2.9.7/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/2.9.7/lib/vendor/lodash.min.js"></script>
    <script src="https://source.zoom.us/zoom-meeting-2.9.7.min.js"></script>
    <script src="{{ asset('js/zoom-js/tool.js') }}" defer></script>
    <script src="{{ asset('js/zoom-js/vconsole.min.js') }}" defer></script>

    <script>
    var testTool = window.testTool;

  ZoomMtg.preLoadWasm(); // pre download wasm file to save time.

  var SDK_KEY = "Rkq4UXKYX4OiZShCKWw8DmnVvkHBDG7tyx8Z";
  var SDK_SECRET = "3sZ76fDo9s78xMZvzN4MQdiRGwuKFsbH7RUI";


  // click join meeting button
function goMeet(){
      var meetingConfig = testTool.getMeetingConfig();

      
      testTool.setCookie("meeting_number", meetingConfig.mn);
      testTool.setCookie("meeting_pwd", meetingConfig.pwd);

      var signature = ZoomMtg.generateSDKSignature({
        meetingNumber: meetingConfig.mn,
        sdkKey: SDK_KEY,
        sdkSecret: SDK_SECRET,
        role: meetingConfig.role,
        success: function (res) {
          console.log(res.result);
          meetingConfig.signature = res.result;
          meetingConfig.sdkKey = SDK_KEY;
          sessionStorage.setItem('dMeet',JSON.stringify(meetingConfig))
          var joinUrl = "/meeting";
          window.location.href = joinUrl;
        },
      });
    }
    $( document ).ready(function() {
    goMeet();
});

    </script>
</body>

</html>