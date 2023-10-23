import { initializeApp } from "firebase/app";
import {getAuth} from 'firebase/auth'

const firebaseConfig = {
  apiKey: "AIzaSyBVSYtwlE5pG6ZRgIPAE6oCIiuqyMCv-_k",
  authDomain: "guestease-8911b.firebaseapp.com",
  projectId: "guestease-8911b",
  storageBucket: "guestease-8911b.appspot.com",
  messagingSenderId: "1084264688275",
  appId: "1:1084264688275:web:76ee99c973316892f3bb66",
  measurementId: "G-Q37JKHWGK8"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app)

export { auth }