<script setup>

    import {ref} from 'vue'
    import {useForm, router} from '@inertiajs/vue3'
    import Layout from '../../Layouts/AuthLayout.vue'
    import { getAuth, signInWithEmailAndPassword } from "firebase/auth"
    
    defineOptions({layout: Layout})

    const passwordVisible = ref(true)
    const loadingLoginButton = ref(false)
    const errorMssg = ref('')
    
    const form = useForm({
        email: '',
        password: ''
    })

    const submit = () => {
        loadingLoginButton.value = true
        signInWithEmailAndPassword(getAuth(), form.email, form.password)
        .then((userCredential) => {
            loadingLoginButton.value = false
            if(userCredential.user.emailVerified) {
                form.post('/login', { onSuccess: () => {
                    loadingLoginButton.value = false
                }})
            }
            else {
                router.get('/verify')
            }
        })
        .catch((error) => {
            loadingLoginButton.value = false
            errorMssg.value = "auth/invalid-login-credentials"
        })
    }

    const emailRules = [
        value => {
            if (value) return true
            return 'E-mail is required'
        },
        value => {
            if (/.+@.+\..+/.test(value)) return true
            return 'E-mail must be valid'
        },
    ]

    const passwordRules = [
        value => {
            if(value) return true
            return `Password is required`
        }
    ]

</script>

<template>
    <Head title="Login" />
    <v-container class="wrapper fadeInDown ">
        <!-- <form method="POST" action="/users/authenticate"> -->
        <v-form @submit.prevent>
            <v-row id="formContent">
                <v-col cols="7" xxl="7" xl="7" lg="7" md="7">
                    <v-card height="100%" elevation="0">
                        <v-card-item class="fill-height">
                            <v-img src="../images/logo/frlogo-transformed.png"  class=" fadeIn second"></v-img>
                        </v-card-item>
                    </v-card>
                </v-col>
                <v-divider vertical/>
                <v-col cols="5" xxl="5" xl="5" lg="5" md="5">
                    <v-card elevation="0">
                        <p class="fadeIn first text-h5 font-weight-bold">LOGIN</p>
                        <label class="mt-4 fadeIn third">Don't have an account? </label>
                        <Link href="/createGuest" class="text-blue fadeIn third"> Sign up</Link>
                        <v-card-item>
                            <v-container>
                                <v-text-field 
                                    v-model="form.email" 
                                    color="blue" 
                                    clearable
                                    name="email"
                                    :rules="emailRules"
                                    variant="outlined" 
                                    class="fadeIn second mx-5" 
                                    placeholder="johndoe@gmail.com" 
                                    label="Email address">
                                </v-text-field>
                                <v-text-field 
                                    v-model="form.password" 
                                    color="blue" 
                                    variant="outlined"
                                    name="password"
                                    :rules="passwordRules"
                                    class="fadeIn second mx-5" 
                                    :error-messages="errorMssg || form.errors.loginError"
                                    :type="passwordVisible ? 'password' : 'text'"
                                    :append-inner-icon="passwordVisible ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append-inner="passwordVisible = !passwordVisible" 
                                    label="Password">
                                </v-text-field>
                                <Link href="/forgot-password" class="text-blue mb-2 third fadeIn">Forgot your password?</Link>
                                <v-btn color="blue" class="fadeIn third" id="btn-login" :loading="loadingLoginButton" :disabled="loadingLoginButton" @click="submit" type="submit" block>Log in</v-btn>
                                <!-- <v-btn color="blue" class="fadeIn third my-3" id="btn-login" prepend-icon="mdi-google" block @click="handleGoogleSignin">Continue with Google</v-btn>
                                <v-btn color="blue" class="fadeIn third" id="btn-login" prepend-icon="mdi-facebook" block @click="handleFacebookSignin">Continue with Facebook</v-btn> -->
                                <!-- <GoogleLogin class="my-3 fadeIn third" :callback="handleGoogleResponse"/> -->
                                
                                <br>
                                <label class="mt-4 fadeIn third">List your property? </label>
                                <Link href="/createOwner" class="text-blue fadeIn third"> Create owner account</Link>
                            </v-container>
                        </v-card-item>
                    </v-card>
                </v-col>
                
            </v-row>
        </v-form>
    </v-container>
</template>

<style scoped>

html {
    background-color: #0389cc;
  }
  
  body {
    font-family: "Poppins", sans-serif;
    height: 100vh;
  }
  
  a {
    color: #92badd;
    display:inline-block;
    text-decoration: none;
    font-weight: 400;
  }
  
  h2 {
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
    display:inline-block;
    margin: 40px 8px 10px 8px; 
    color: #cccccc;
    
  }
  input[type=button] {

    background-color: #39ace7;
  }
  input[type=button]:hover {
    background-color: #5fbae9;
  }
  
  
  
  /* STRUCTURE */
  
  .wrapper {
    display: flex;
    align-items: center;
    flex-direction: column; 
    justify-content: center;
    width: 100%;
    min-height: 100%;
    padding: 20px;
  }
  
  #formContent {
    background: #fff;
    padding: 30px;
    position: relative;
    padding: 0px;
    -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
    box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
    text-align: center;
    width: 1000px;
  }
  
  #formFooter {
    background-color: #f6f6f6;
    border-top: 1px solid #dce8f1;
    padding: 25px;
    text-align: center;
    -webkit-border-radius: 0 0 10px 10px;
    border-radius: 0 0 10px 10px;
  }
  
  
  
  /* TABS */
  
  h2.inactive {
    color: #cccccc;
  }
  
  h2.active {
    color: #0d0d0d;
    border-bottom: 2px solid #5fbae9;
  }
  
  
  
  /* FORM TYPOGRAPHY*/
  
  input[type=button], input[type=submit], input[type=reset]  {
    background-color: #56baed;
    border: none;
    color: white;
    padding: 15px 80px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    text-transform: uppercase;
    font-size: 13px;
    -webkit-box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
    box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
    -webkit-border-radius: 5px 5px 5px 5px;
    border-radius: 5px 5px 5px 5px;
    margin: 5px 20px 40px 20px;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
  }
  
  input[type=button]:hover, input[type=submit]:hover, input[type=reset]:hover  {
    background-color: #39ace7;
  }
  
  input[type=button]:active, input[type=submit]:active, input[type=reset]:active  {
    -moz-transform: scale(0.95);
    -webkit-transform: scale(0.95);
    -o-transform: scale(0.95);
    -ms-transform: scale(0.95);
    transform: scale(0.95);
  }
  
  input {
    background-color: #f6f6f6;
    border: none;
    color: #0d0d0d;
    padding: 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 5px;
    width: 85%;
    border: 2px solid #f6f6f6;
    -webkit-transition: all 0.5s ease-in-out;
    -moz-transition: all 0.5s ease-in-out;
    -ms-transition: all 0.5s ease-in-out;
    -o-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out;
    -webkit-border-radius: 5px 5px 5px 5px;
    border-radius: 5px 5px 5px 5px;
  }
  
  input:focus{
    background-color: #fff;
    border-bottom: 2px solid #5fbae9;
  }
  
  input:placeholder {
    color: #cccccc;
  }
  
  /* ANIMATIONS */
  
  /* Simple CSS3 Fade-in-down Animation */
  .fadeInDown {
    -webkit-animation-name: fadeInDown;
    animation-name: fadeInDown;
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
  }
  
  @-webkit-keyframes fadeInDown {
    0% {
      opacity: 0;
      -webkit-transform: translate3d(0, -100%, 0);
      transform: translate3d(0, -100%, 0);
    }
    100% {
      opacity: 1;
      -webkit-transform: none;
      transform: none;
    }
  }
  
  @keyframes fadeInDown {
    0% {
      opacity: 0;
      -webkit-transform: translate3d(0, -100%, 0);
      transform: translate3d(0, -100%, 0);
    }
    100% {
      opacity: 1;
      -webkit-transform: none;
      transform: none;
    }
  }
  
  /* Simple CSS3 Fade-in Animation */
  @-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
  @-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
  @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
  
  .fadeIn {
    opacity:0;
    -webkit-animation:fadeIn ease-in 1;
    -moz-animation:fadeIn ease-in 1;
    animation:fadeIn ease-in 1;
  
    -webkit-animation-fill-mode:forwards;
    -moz-animation-fill-mode:forwards;
    animation-fill-mode:forwards;
  
    -webkit-animation-duration:1s;
    -moz-animation-duration:1s;
    animation-duration:1s;
  }
  
  .fadeIn.first {
    -webkit-animation-delay: 0.4s;
    -moz-animation-delay: 0.4s;
    animation-delay: 0.4s;
  }
  
  .fadeIn.second {
    -webkit-animation-delay: 0.6s;
    -moz-animation-delay: 0.6s;
    animation-delay: 0.6s;
  }
  
  .fadeIn.third {
    -webkit-animation-delay: 0.8s;
    -moz-animation-delay: 0.8s;
    animation-delay: 0.8s;
  }
  
  .fadeIn.fourth {
    -webkit-animation-delay: 1s;
    -moz-animation-delay: 1s;
    animation-delay: 1s;
  }
  
  .fadeIn.fifth {
    -webkit-animation-delay: 1.4s;
    -moz-animation-delay: 1.4s;
    animation-delay: 1.4s;
  }
  
  /* Simple CSS3 Fade-in Animation */
  .underlineHover:after {
    display: block;
    left: 0;
    bottom: -10px;
    width: 0;
    height: 2px;
    background-color: #56baed;
    content: "";
    transition: width 0.2s;
  }
  
  .underlineHover:hover {
    color: #0d0d0d;
  }
  
  .underlineHover:hover:after{
    width: 100%;
  }
  
  /* OTHERS */
  
  *:focus {
      outline: none;
  } 
  
  #icon {
    width:60%;
  }

  

</style>