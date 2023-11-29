import { initializeApp } from "firebase/app";
import {getAuth} from 'firebase/auth'

const firebaseConfig = {
  apiKey: "AIzaSyC5jQSozly2PNghwH8f8RwrlxeO5pFb8E8",
  authDomain: "guestease-c1d26.firebaseapp.com",
  projectId: "guestease-c1d26",
  storageBucket: "guestease-c1d26.appspot.com",
  messagingSenderId: "59009367910",
  appId: "1:59009367910:web:502a37f31f3f61bbad52a7",
  measurementId: "G-F794NY9HYX"
};
// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app)

export { auth }
