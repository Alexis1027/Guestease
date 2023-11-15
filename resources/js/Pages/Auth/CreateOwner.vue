<script setup>

    import {ref} from 'vue'
    import { useForm } from '@inertiajs/vue3';
    import { getAuth, createUserWithEmailAndPassword, sendEmailVerification  } from "firebase/auth";
    import Layout from '../../Layouts/AuthLayout.vue'

    defineOptions({layout: Layout})

    const passwordVisible = ref(true)
    const auth = getAuth()
    const signupButton = ref(false)
    const emailErrMsg = ref('')
    const form = useForm({
        firstname: '',
        lastname: '',
        email: '',
        password: '',
        phone_number: '',
        role: 'owner'
    })

    function sign_up() {
        signupButton.value = true
        form.post('/validate/user', {
            onSuccess: () => {
                form.post('/create/user')
                createUserWithEmailAndPassword(auth, form.email, form.password)
                .then((userCredential) => {
                    sendEmailVerification(auth.currentUser)
                    .then(() => {
                        alert('Email verification sent!')
                    });
                })
                .catch((error) => {
                    signupButton.value = false
                    emailErrMsg.value = "Email is already in use"
                    console.log(error.message);
                    // ..
                })
            },
            onError: () => {
                signupButton.value = false
            }
        })
    }

</script>

<template>
    <Head title="Register" />
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <div class="fadeIn first">
                <div class="row text-center">
                    <p class="text-h5 pt-3">
                        <i class="fa fa-address-card-o" aria-hidden="true"></i> Create owner account
                    </p>
                </div>
            </div>
            <v-form @submit.prevent>
                <v-card elevation="0">
                    <v-card-item>
                        <v-container class="mt-2">
                            <v-row class="mx-2">
                                    <v-text-field 
                                        color="blue"
                                        clearable
                                        name="firstname"
                                        v-model="form.firstname"
                                        variant="outlined"
                                        :error-messages="form.errors.firstname" 
                                        class="fadeIn second" 
                                        label="First name">
                                    </v-text-field>
                            </v-row>
                            <v-row class="mx-2">
                                <v-text-field 
                                        color="blue" 
                                        clearable 
                                        name="lastname"
                                        v-model="form.lastname"
                                        :error-messages="form.errors.lastname" 
                                        variant="outlined" 
                                        class="fadeIn second" 
                                        label="Last name">
                                    </v-text-field>
                            </v-row>
                            <v-row class="mb-2 mx-2">
                                    <MazPhoneNumberInput
                                    v-model="form.phone_number"
                                    show-code-on-list
                                    style="width: 100%;"
                                    color="primary"
                                    class="fadeIn first"
                                    name="phone_number"
                                    :onlyCountries="['PH']"
                                    defaultCountryCode="PH"
                                    @update="results = $event"
                                    :success="results?.isValid"
                                    label="Phone number"
                                    :error="form.errors.phone_number"
                                />
                                <p v-if="form.errors.phone_number" class="text-red text-center" style="font-size: 12px;">{{ form.errors.phone_number }}</p>
                            </v-row>
                            <v-row class="mx-2">
                                <v-text-field 
                                    color="blue" 
                                    clearable 
                                    name="email"
                                    v-model="form.email"
                                    variant="outlined" 
                                    :error-messages="form.errors.email || form.errors.email" 
                                    class="fadeIn second" 
                                    placeholder="johndoe@gmail.com" 
                                    label="Email">
                                </v-text-field>
                            </v-row>
                            <v-row class="mx-2">
                                <v-text-field 
                                    color="blue" 
                                    v-model="form.password"
                                    :error-messages="form.errors.password" 
                                    variant="outlined" 
                                    name="password"
                                    class="fadeIn second" 
                                    :type="passwordVisible ? 'password' : 'text'"
                                    :append-inner-icon="passwordVisible ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append-inner="passwordVisible = !passwordVisible" 
                                    label="Password">
                                </v-text-field>
                            </v-row>
                            <!-- <v-text-field color="blue" clearable variant="outlined" class="fadeIn second mx-5" label="Confirm password"></v-text-field> -->
                            <v-btn block class="fadeIn third" :loading="signupButton" :disabled="signupButton" @click="sign_up" type="submit" id="btn-login" color="blue">Register</v-btn>
                        </v-container>
                        <label class="mt-4 fadeIn third">Already have an account? </label>
                        <Link href="/login" class="text-blue mb-4 fadeIn third"> Log In </Link>

                    </v-card-item>
                </v-card>
            </v-form>
        </div>
    </div>
</template>

<style scoped>

  .wrapper {
    display: flex;
    align-items: center;
    flex-direction: column; 
    justify-content: center;
    width: 100%;
    min-height: 100%;
    padding: 20px;
  }

  a {
    text-decoration: none;

  }
  
  #formContent {
    background: #fff;
    padding: 30px;
    width: 600px;
    max-width: 500px;
    position: relative;
    padding: 0px;
    -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
    box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
    text-align: center;
  }
  
  
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
  
  
</style>
