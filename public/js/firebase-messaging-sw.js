// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyCBVYziGDCS2sMLxrGGm7PtG83XeJedfAE",
        authDomain: "instel-cali.firebaseapp.com",
        projectId: "instel-cali",
        storageBucket: "instel-cali.appspot.com",
        messagingSenderId: "1068845546830",
        appId: "1:1068845546830:web:ade61255df7944da75321f"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/apple-icon-72x72.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});