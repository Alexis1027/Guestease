<script setup>

    defineOptions({layout: Layout})
    import {ref} from 'vue'
    import Layout from '../../Layouts/AuthLayout.vue'
    import { getAuth, sendPasswordResetEmail } from "firebase/auth"
    

    const sendButton = ref(false)
    const email = ref('')
    const linkSent = ref(false)
    const send = () => {
        sendButton.value = true
        sendPasswordResetEmail(getAuth(), email.value)
        .then(() => {
            linkSent.value = true
            sendButton.value = false
            alert('Success! Please check your email.')
        })
        .catch((error) => {
            sendButton.value = false
            alert(error.message)
        });
    }

    const emailRules = [
        value => {
            if (value) return true
            return 'E-mail is requred.'
        },
        value => {
            if (/.+@.+\..+/.test(value)) return true
            return 'E-mail must be valid.'
        },
    ]
</script>

<template>
    <Head title="Forgot password" />
    <v-container>
        <v-row class="bg-white" style="margin: auto; margin-top: 8%;">
            <v-col cols="12" md="6" style="margin: auto">
                <v-card elevation="0">
                    <v-img src="../images/logo/frlogo-transformed.png"></v-img>
                </v-card>
            </v-col>
            <v-col cols="12" md="6">
                <v-card elevation="0">
                    <template v-slot:title>
                        <p class="text-center">Forgot password</p>
                    </template>
                    <v-card-item v-if="!linkSent">
                        <p class="pa-3 text-center">Please provide the email address that you used when you signed up for you account.</p>
                        <v-container>
                            <v-text-field 
                                v-model="email" 
                                color="blue" 
                                clearable
                                name="email"
                                :rules="emailRules"
                                variant="outlined" 
                                class="fadeIn second mx-5" 
                                placeholder="johndoe@gmail.com" 
                                :error-messages="$page.props.errors.email"
                                label="Email address">
                            </v-text-field>
                            <p class="text-center text-caption">We will send you an email that will allow you to reset your password.</p>
                            <v-btn color="blue" class="fadeIn third" id="btn-login" :loading="sendButton" :disabled="sendButton" @click="send" type="submit" block>Send</v-btn>
                        </v-container>
                    </v-card-item>
                    <v-card-item v-else>
                        <v-alert color="green" variant="tonal" icon="mdi-check-circle-outline" title="Sent!">
                            An email with a link to reset your password has just been sent to your email.
                        </v-alert>
                        <Link href="/login">
                            <v-btn color="blue" block class="mt-2">Back to login</v-btn>
                        </Link>
                    </v-card-item>
                </v-card>
            </v-col>
        </v-row>
   </v-container>
</template>