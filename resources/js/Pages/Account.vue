<script setup>

    import {ref} from 'vue'
    import {useForm} from '@inertiajs/vue3'
    import Layout from '../Layouts/Layout.vue'
    import MazPhoneNumberInput from 'maz-ui/components/MazPhoneNumberInput'
    import {router} from '@inertiajs/vue3'

    defineOptions({layout: Layout})

    const props = defineProps(['auth', 'showInputVerificationCodeProp'])
    const sendVerificationCodeLoading = ref(false)
    const verificationCode = ref('')
    const results = ref()
    const snackbar = ref(false)
    const form = useForm({
        firstname: props.auth.user.firstname,
        lastname: props.auth.user.lastname,
        phone_number: props.auth.user.phone_number,
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

    const sendVerificationCodeForm = useForm({
        phoneNumber: props.auth.user.contact_no
    })

    const verifyVerificationCodeForm = useForm({
        code: null
    })

    function sendVerificationCode() {
        sendVerificationCodeForm.get('/sendVerificationCode', {
            preserveState: true,
            preserveScroll: true
        })
    }

    function verifyVerificationCode() {
        verifyVerificationCodeForm.get('/verifyVerificationCode')
    }

</script>


<template>
    <Head title="Account" />
    <v-breadcrumbs :items="[{title: 'Account', disabled: false}, {title: 'Personal info', disabled: false}]">
        <template v-slot:divider>
            <v-icon icon="mdi-chevron-right"></v-icon>
        </template>
    </v-breadcrumbs>
    <v-card width="80%" class="border mb-4" title="Profile picture">
        <v-card-item>
            <v-avatar size="100">
                <v-img src="/images/profile/21.png" ></v-img>
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
                <v-col cols="5">
                    <MazPhoneNumberInput
                        v-model="form.phone_number"
                        show-code-on-list
                        color="primary"
                        :onlyCountries="['PH']"
                        defaultCountryCode="PH"
                        @update="results = $event"
                        :success="results?.isValid"
                    />
                </v-col>
                <v-col cols="3" class="mt-2">
                    <p class="text-green" v-if="auth.phone_number_verified"><v-icon>mdi-check</v-icon> Verified</p>
                    <v-btn type="submit" v-else color="blue" :loading="sendVerificationCodeLoading" :disabled="sendVerificationCodeLoading" @click="sendVerificationCode">Send SMS code</v-btn>
                </v-col>
            </v-row>
            <v-row v-if="sendVerificationCodeForm.wasSuccessful">
                <v-col cols="5">
                    <div>
                        <v-text-field type="number" placeholder="******" label="Enter verification code" v-model="verifyVerificationCodeForm.code" variant="outlined">
                            <template v-slot:append>
                                <v-btn color="blue" @click="verifyVerificationCode">
                                    Verify
                                </v-btn>
                            </template>
                        </v-text-field>
                    </div>
                </v-col>
            </v-row>
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

