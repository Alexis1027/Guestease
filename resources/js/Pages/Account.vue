<script setup>

    defineOptions({ layout: Layout })
    const props = defineProps(['auth', 'showInputVerificationCodeProp'])
    import {ref} from 'vue'
    import {useForm} from '@inertiajs/vue3'
    import Layout from '../Layouts/Layout.vue'
    import MazPhoneNumberInput from 'maz-ui/components/MazPhoneNumberInput'

    const showFileInput = ref(false)
    const results = ref()
    const snackbar = ref(false)
    const form = useForm({
        firstname: props.auth.user.firstname,
        lastname: props.auth.user.lastname,
        phone_number: props.auth.user.phone_number,
        address: props.auth.user.address,
    })

    const profilePicForm = useForm({
        profile_pic: null
    })

    const submit = () => {
        if(results.value.isValid) {
            console.log('bruh')
            form.put('/account/update', {
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
    <Head title="Account" />
    <v-breadcrumbs :items="[{title: 'Account', disabled: false}, {title: 'Personal info', disabled: false}]">
        <template v-slot:divider>
            <v-icon icon="mdi-chevron-right"></v-icon>
        </template>
    </v-breadcrumbs>
    <v-card width="80%" class="border mb-4" title="Profile picture">
        <v-card-item>
            <v-avatar size="100">
                <v-img :src="`/images/profile/${auth.user.profile_pic}`" ></v-img>
            </v-avatar>
            <v-btn class="text-none mx-6" prepend-icon="mdi-pencil" v-if="!showFileInput" @click="showFileInput = true" color="blue">Edit profile picture</v-btn>
            <v-btn v-else class="text-none mx-6" prepend-icon="mdi-pencil" color="red" @click="showFileInput = false"> Cancel</v-btn>
            <div v-if="showFileInput">
                <v-file-input class="mt-2" name="profile_pic" v-model="profilePicForm.profile_pic" variant="outlined" label="File input">
                    <template v-slot:append>
                        <v-btn color="green" class="ms-5" @click="profilePicForm.post(`/account/update-profile_pic`, {onSuccess: () => {showFileInput = false}})">Save</v-btn>
                    </template>
                </v-file-input>
            </div>
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
                        :error="form.errors.phone_number"
                    />
                    <p class="text-error">{{ form.errors.phone_number }}</p>
                </v-col>
            </v-row>
           
            <v-text-field class="mt-4" variant="outlined" clearable :error-messages="form.errors.address" label="Address" color="blue" v-model="form.address"></v-text-field>
        </v-card-item>
        <v-card-actions class="justify-end d-flex">
            <v-btn rounded="pill" variant="flat" class="text-none" type="submit" @click="submit" :loading="form.processing" :disabled="form.processing" color="blue">Save</v-btn>
        </v-card-actions>
    </v-card>

        <v-snackbar
            v-model="snackbar"
            multi-line
            color="blue"
            class="text-center"
            location="bottom center"
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

