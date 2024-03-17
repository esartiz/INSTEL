window.addEventListener('DOMContentLoaded', function(event) {
  console.log('DOM fully loaded and parsed');
  websdkready();
});

function websdkready() {
  var testTool = window.testTool;
  if (testTool.isMobileDevice()) {
    vConsole = new VConsole();
  }
  console.log("checkSystemRequirements");
  console.log(JSON.stringify(ZoomMtg.checkSystemRequirements()));
  ZoomMtg.preLoadWasm(); // pre download wasm file to save time.

  var SDK_KEY = "Rkq4UXKYX4OiZShCKWw8DmnVvkHBDG7tyx8Z";
  var SDK_SECRET = "3sZ76fDo9s78xMZvzN4MQdiRGwuKFsbH7RUI";


  // click join meeting button

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
          var joinUrl = "/meeting.html?" + testTool.serialize(meetingConfig);
          console.log(joinUrl);
          window.location.href = joinUrl;
        },
      });
}
