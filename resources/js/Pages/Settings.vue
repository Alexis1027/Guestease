<script setup>

    import {ref, onMounted} from 'vue'
    import {useForm} from '@inertiajs/vue3'
    import Layout from '../Layouts/Layout.vue'
    import { getAuth, RecaptchaVerifier, signInWithPhoneNumber } from "firebase/auth";
    import MazPhoneNumberInput from 'maz-ui/components/MazPhoneNumberInput'

    defineOptions({layout: Layout})
    onMounted(() => {
        const phoneNumber = props.auth.user.contact_no

        window.recaptchaVerifier = new RecaptchaVerifier(getAuth(), 'recaptcha-container', {
            'size': 'normal',
            'callback': (response) => {
                const appVerifier = window.recaptchaVerifier
                const auth = getAuth();
                signInWithPhoneNumber(auth, phoneNumber, appVerifier)
                    .then((confirmationResult) => {
                        alert("SMS sent!")
                    // SMS sent. Prompt user to type the code from the message, then sign the
                    // user in with confirmationResult.confirm(code).
                        window.confirmationResult = confirmationResult
                        console.log(confirmationResult)
                    }).catch((error) => {
                    // Error; SMS not sent
                    console.log(error.message)
                    console.log(error)
                    console.log("bruh")
                })
            },
            'expired-callback': () => {
                alert('captcha expired')
            }
        })


    })

    function showCaptcha() {
        recaptchaVerifier.render()
    }

    const props = defineProps(['auth'])
    const results = ref()
    const snackbar = ref(false)
    console.log(props)
    const form = useForm({
        firstname: props.auth.user.firstname,
        lastname: props.auth.user.lastname,
        contact_no: props.auth.user.contact_no,
        address: props.auth.user.address,
        email: props.auth.user.email,
    })


    const submit = () => {
        if(results.value.isValid) {
            console.log('bruh')
            form.put('/profile/update', {
                onSuccess: () => {
                    snackbar.value = true
                }
            })
        }
        else {
            alert('Fill in contact no')
        }
        
    }
</script>


<template>
    <Head title="Account settings" />
    <v-breadcrumbs :items="[{title: 'Account', disabled: false}, {title: 'Personal info', disabled: false}]">
        <template v-slot:divider>
            <v-icon icon="mdi-chevron-right"></v-icon>
        </template>
    </v-breadcrumbs>
        
    <v-card width="80%" class="border mb-4" title="Profile picture">
        <v-card-item>
            <v-avatar size="100">
                <v-img src="../images/profile/21.png" ></v-img>
            </v-avatar>
            <v-btn class="text-none mx-6" color="blue">Upload</v-btn>
            <v-btn class="text-none" variant="text" color="red" prepend-icon="mdi-close">Delete</v-btn>
        </v-card-item>
    </v-card>

    <v-card width="80%" class="border mb-4" title="Personal details">
        <v-card-item>
            <v-text-field class="mt-3" variant="outlined" clearable :error-messages="form.errors.firstname" label="First name" color="blue" v-model="form.firstname"></v-text-field>
            <v-text-field variant="outlined" clearable :error-messages="form.errors.lastname" label="Last name" color="blue" v-model="form.lastname"></v-text-field>
            <v-row>
                <v-col cols="9">
                    <MazPhoneNumberInput
                        v-model="form.contact_no"
                        show-code-on-list
                        color="primary"
                        :onlyCountries="['PH']"
                        defaultCountryCode="PH"
                        @update="results = $event"
                        :success="results?.isValid"
                    />
                </v-col>
                <v-col cols="3">
                    
                    <v-btn type="submit" color="blue" @click="showCaptcha">Send SMS Code</v-btn>
                </v-col>
            </v-row>
            <div id="recaptcha-container" class="my-3"></div>
            <v-text-field class="mt-4" variant="outlined" clearable :error-messages="form.errors.address" label="Address" color="blue" v-model="form.address"></v-text-field>
            <v-text-field variant="outlined" clearable :error-messages="form.errors.email" label="Email" color="blue" v-model="form.email"></v-text-field>
        </v-card-item>
        <v-card-actions class="justify-end d-flex">
            <v-btn rounded="pill" variant="flat" class="text-none" type="submit" @click="submit" :loading="form.processing" :disabled="form.processing" color="blue">Save</v-btn>
        </v-card-actions>
    </v-card>

    <v-card class="border bg-white mt-6" width="80%" title="Change password">
        <v-card-item>
            <span class="text-red">doestn work</span>
            <v-text-field variant="outlined" label="Current password" color="blue"></v-text-field>
            <v-text-field variant="outlined" label="New password" color="blue" ></v-text-field>
            <v-text-field variant="outlined" label="Confirm new password" color="blue"></v-text-field>
        </v-card-item>
        <v-card-actions class="justify-end d-flex">
            <v-btn rounded="pill" class="text-none" variant="flat" color="blue">Save</v-btn>
        </v-card-actions>
    </v-card>
        

        <v-snackbar
      v-model="snackbar"
      multi-line
      color="blue"
      class="text-end"
      location="bottom right"
      timeout="1200"
    >
      Update Sucessful.
      <template v-slot:actions>
        <v-btn
          color="white"
          variant="text"
          @click="snackbar = false"
          icon="mdi-close"
        >
        </v-btn>
      </template>
    </v-snackbar>

</template>

