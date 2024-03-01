import { initializeApp } from "firebase/app";
import {getAuth} from 'firebase/auth'

// alexis firebase
const firebaseConfig = {
  apiKey: "AIzaSyC5jQSozly2PNghwH8f8RwrlxeO5pFb8E8",
  authDomain: "guestease-c1d26.firebaseapp.com",
  projectId: "guestease-c1d26",
  storageBucket: "guestease-c1d26.appspot.com",
  messagingSenderId: "59009367910",
  appId: "1:59009367910:web:502a37f31f3f61bbad52a7",
  measurementId: "G-F794NY9HYX"
};

// const firebaseConfig = {
//   apiKey: "AIzaSyBVSYtwlE5pG6ZRgIPAE6oCIiuqyMCv-_k",
//   authDomain: "guestease-8911b.firebaseapp.com",
//   projectId: "guestease-8911b",
//   storageBucket: "guestease-8911b.appspot.com",
//   messagingSenderId: "1084264688275",
//   appId: "1:1084264688275:web:76ee99c973316892f3bb66",
//   measurementId: "G-Q37JKHWGK8"
// }

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app)

export { auth }
