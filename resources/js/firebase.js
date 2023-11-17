import { initializeApp } from "firebase/app";
import {getAuth} from 'firebase/auth'

const firebaseConfig = {
    apiKey: "AIzaSyBvJaDNFoC6LryDhLT-NJyL9dUQMkDWEVw",
    authDomain: "guestease-5dec8.firebaseapp.com",
    projectId: "guestease-5dec8",
    storageBucket: "guestease-5dec8.appspot.com",
    messagingSenderId: "794543510427",
    appId: "1:794543510427:web:2277b0249b7f880770c73e",
    measurementId: "G-M8ZHJGNE0F"
  };
// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app)

export { auth }
