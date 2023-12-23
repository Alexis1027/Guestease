<script setup>

    defineOptions({layout: Layout})
    import {ref} from 'vue'
    import {useForm, router} from '@inertiajs/vue3'
    import Layout from '../../Layouts/AuthLayout.vue'
    import { getAuth, signInWithEmailAndPassword } from "firebase/auth"

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
            console.log(error)
            loadingLoginButton.value = false
            errorMssg.value = "The password you’ve entered is incorrect. Forgot Password?"
        })
    }

    const emailRules = [
        value => {
            if (value.length > 1) return true
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
    <Head title="Login"/>
    <v-container style="height: 100vh; ">
        <v-row class="bg-white" style="margin: auto; margin-top: 8%;">
            <v-col cols="12" md="6" style="margin: auto" >
                <v-card elevation="0" >
                    <v-img src="../images/logo/frlogo-transformed.png" cover></v-img>
                </v-card>
            </v-col>
            <v-divider vertical></v-divider>
            <v-col cols="12" md="6">
                <v-form @submit.prevent fast-fail>
                    <v-card elevation="0" width="auto" @submit.prevent>
                        <template v-slot:title>
                            <p class="text-center font-weight-bold">Login</p>
                        </template>
                        <p class="text-center">Don't have an account? <Link href="/createGuest" class="text-blue fadeIn third"> Sign up</Link> </p>
                        <v-card-item>
                            <v-text-field 
                                v-model="form.email" 
                                color="blue" 
                                clearable
                                name="email"
                                :rules="emailRules"
                                variant="outlined" 
                                class="mt-2 mx-5" 
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
                            <Link href="/forgot-password" class="text-blue"> <p class="text-end mb-2 ">Forgot your password?</p> </Link>
                            <v-btn color="blue" class="fadeIn third" id="btn-login" :loading="loadingLoginButton" :disabled="loadingLoginButton" @click="submit" type="submit" block>Log in</v-btn>
                            <br>
                            <p class="text-center">List your property?  <Link href="/createOwner" class="text-blue fadeIn third"> Create owner account</Link> </p>
                        </v-card-item>
                    </v-card>
                </v-form>
            </v-col>
        </v-row>
    </v-container>
</template>