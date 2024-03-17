importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
   
firebase.initializeApp({
    apiKey: "AIzaSyCBVYziGDCS2sMLxrGGm7PtG83XeJedfAE",
    projectId: "instel-cali",
    messagingSenderId: "1068845546830",
    appId: "1:1068845546830:web:ade61255df7944da75321f"
});
  
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});