<script setup>

    import {ref} from 'vue'
    import { useForm } from '@inertiajs/vue3';
    import { getAuth, createUserWithEmailAndPassword, sendEmailVerification  } from "firebase/auth";
    import Layout from '../../Layouts/AuthLayout.vue'

    defineOptions({layout: Layout})

    const auth = getAuth()
    const passwordVisible = ref(true)
    const signupButton = ref(false)
    const emailErrMsg = ref('')
    const form = useForm({
        firstname: '',
        lastname: '',
        email: '',
        password: '',
        phone_number: '',
        role: 'guest'
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
    <v-row justify="center">
        <v-col cols="11" sm="8" md="6" lg="6" xl="6"  style="margin-top: 5%;">
            <v-form @submit.prevent>
                <v-card>
                    <template v-slot:title>
                        <p class="text-center">Create guest account</p>
                    </template>
                    <v-card-item>
                        <v-text-field 
                            color="blue"
                            clearable
                            name="firstname"
                            v-model="form.firstname"
                            class="mt-2"
                            variant="outlined"
                            :error-messages="form.errors.firstname" 
                            label="First name">
                        </v-text-field>
                        <v-text-field 
                            color="blue"
                            clearable
                            name="lastname"
                            v-model="form.lastname"
                            variant="outlined"
                            :error-messages="form.errors.lastname" 
                            label="Last name">
                        </v-text-field>
                        <MazPhoneNumberInput
                            v-model="form.phone_number"
                            show-code-on-list
                            style="width: 100%;"
                            color="primary"
                            name="phone_number"
                            :onlyCountries="['PH']"
                            defaultCountryCode="PH"
                            @update="results = $event"
                            :success="results?.isValid"
                            label="Phone number"
                            :error="form.errors.phone_number"
                        />
                        <p v-if="form.errors.phone_number" class="text-red text-start" style="font-size: 12px;">{{ form.errors.phone_number }}</p>
                        <v-text-field 
                            color="blue" 
                            clearable 
                            name="email"
                            v-model="form.email"
                            variant="outlined" 
                            class="mt-4"
                            :error-messages="form.errors.email || form.errors.email" 
                            placeholder="johndoe@gmail.com" 
                            label="Email">
                        </v-text-field>
                        <v-text-field 
                            color="blue" 
                            v-model="form.password"
                            :error-messages="form.errors.password" 
                            variant="outlined" 
                            name="password"
                            :type="passwordVisible ? 'password' : 'text'"
                            :append-inner-icon="passwordVisible ? 'mdi-eye' : 'mdi-eye-off'"
                            @click:append-inner="passwordVisible = !passwordVisible" 
                            label="Password">
                        </v-text-field>
                        <v-btn :loading="signupButton" block :disabled="signupButton" @click="sign_up" type="submit" id="btn-login" color="blue">Register</v-btn>
                    </v-card-item>
                    <v-card-item>
                        <p class="text-center">Already have an account? <Link href="/login" class="text-blue mb-4"> Log In </Link> </p>
                    </v-card-item>
                </v-card>
            </v-form>
        </v-col>
    </v-row>
</template>