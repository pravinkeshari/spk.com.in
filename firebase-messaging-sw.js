importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-auth.js');

firebase.initializeApp({
    apiKey: "AIzaSyBnMx11HAqjuylptfDn-0FXVAd_v_lwpWE",
    authDomain: "spkrk-132c4.firebaseapp.com",
    projectId: "spkrk-132c4",
    storageBucket: "spkrk-132c4.firebasestorage.app",
    messagingSenderId: "920588815207",
    appId: "1:920588815207:web:859c274e46ff03d7903dc2",
    measurementId: "G-F53J7T7EY7"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    return self.registration.showNotification(payload.data.title, {
        body: payload.data.body || '',
        icon: payload.data.icon || ''
    });
});