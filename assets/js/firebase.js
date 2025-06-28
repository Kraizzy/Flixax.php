// firebase-init.js
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.11.0/firebase-app.js";
import {
  getAuth,
  GoogleAuthProvider,
  onAuthStateChanged,
  signInWithPopup,
  signOut
} from "https://www.gstatic.com/firebasejs/10.11.0/firebase-auth.js";

// Firebase config
const firebaseConfig = {
  apiKey: "AIzaSyBKF8aSovnjDyQvt8jynLaO4ozk02fYYbo",
  authDomain: "flixax-web.firebaseapp.com",
  projectId: "flixax-web",
  storageBucket: "flixax-web.appspot.com",
  messagingSenderId: "986244187088",
  appId: "1:986244187088:web:1b31dc428dee4300346fd5",
  measurementId: "G-BT5STQJC7G"
};

// Initialize Firebase app once
const app = initializeApp(firebaseConfig);

// Setup Auth
const auth = getAuth(app);
const provider = new GoogleAuthProvider();

// Export the reusable parts
export { auth, provider, signInWithPopup, signOut, onAuthStateChanged };
