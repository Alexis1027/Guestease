<script setup>

    defineOptions({layout: AdminLayout})
    import AdminLayout from '../../Layouts/AdminLayout.vue'
    import {useForm} from '@inertiajs/vue3'
    import {ref} from 'vue'
    import { getAuth, createUserWithEmailAndPassword, sendEmailVerification  } from "firebase/auth";
    const auth = getAuth()


    const createSuccessful = ref(false)
    const passwordVisible = ref(true)
    const signupButton = ref(false)
    const form = useForm({
        firstname: null,
        lastname: null,
        email: null,
        password: null,
        phone_number: null,
        role: 'admin'
    })

    function sign_up() {
        signupButton.value = true
        form.post('/validate/user', {
            onSuccess: () => {
                form.post('/admin/create-admin')

                createUserWithEmailAndPassword(auth, form.email, form.password)
                .then((userCredential) => {
                    sendEmailVerification(auth.currentUser)
                    .then(() => {
                        form.reset()
                        createSuccessful.value = true
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
    <Head title="Create admin" />
    <v-container>
        <v-row justify="center">
            <v-col cols="12" lg="6" md="12" sm="12" xl="6">
                <v-card title="Create admin" width="100%">
                    <v-card-item>
                        <v-row class="mx-2 mt-2">
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
                                name="phone_number"
                                style="width: 100%;"
                                color="primary"
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
                                :error-messages="form.errors.email" 
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
                        <v-btn block class="fadeIn third my-2" :loading="form.processing" :disabled="form.processing" @click="sign_up" type="submit" id="btn-login" color="blue">Create</v-btn>
                    </v-card-item>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
        <v-snackbar v-model="createSuccessful" color="blue-lighten-3" timeout="5000">
            Admin created successfully. Check email for email verification to activate account.
            <template v-slot:actions>
                <v-btn variant="text" @click="createSuccessful = false" icon="mdi-close">
                </v-btn>
            </template>
        </v-snackbar>
</template>

