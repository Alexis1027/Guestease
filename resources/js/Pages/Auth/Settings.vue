<script setup>

    import {ref} from 'vue'
    import {useForm} from '@inertiajs/vue3'
    import Layout from '../../shared/Layout.vue'
    const {auth} = defineProps(['auth'])
    defineOptions({layout: Layout})

    const form = useForm({
        firstname: auth.user.firstname,
        lastname: auth.user.lastname,
        contact_no: auth.user.contact_no,
        address: auth.user.address,
        email: auth.user.email,
    })

    const submit = () => {
        form.put('/profile/update', {
            onSuccess: () => {
                snackbar.value = true
            }
        })
    }

    const snackbar = ref(false)

</script>


<template>
        <Head title="Settings" />
        <v-card class="bg-white">
            <v-card-item>
                <v-row>
                    <v-col cols="4">
                        <p class="text-h5">Profile information</p>
                        <p>Update your profile's account information.</p>
                    </v-col>
                    <v-col cols="2">
                        <v-avatar size="106px">
                            <v-img alt="Avatar" :src="`../images/Profile/${auth.user.profile_pic}`"></v-img>
                        </v-avatar>
                    </v-col>
                    <v-col>
                        <v-row>
                            <v-btn class="mt-5 text-none" rounded="pill" color="blue">Change picture</v-btn>
                        </v-row>
                        <v-row>
                            <v-btn class="mt-5 text-none" rounded="pill" color="red">Delete picture</v-btn>
                        </v-row>
                    </v-col>
                </v-row>
                <v-form>
                    <v-row>
                        <v-col cols="5">
                            <v-text-field variant="outlined" :error-messages="form.errors.firstname" label="First name" color="blue" v-model="form.firstname"></v-text-field>
                        </v-col>
                        <v-col cols="5">
                            <v-text-field variant="outlined" :error-messages="form.errors.lastname" label="Last name" color="blue" v-model="form.lastname"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="5">
                            <v-text-field variant="outlined" :error-messages="form.errors.contact_no" label="Contact number" color="blue" v-model="form.contact_no"></v-text-field>
                        </v-col>
                        <v-col cols="5">
                            <v-text-field variant="outlined" :error-messages="form.errors.address" label="Address" color="blue" v-model="form.address"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="10">
                            <v-text-field variant="outlined" :error-messages="form.errors.email" label="Email" color="blue" v-model="form.email"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-btn rounded="pill" class="text-none" type="submit" @click="submit" :loading="form.processing" :disabled="form.processing" color="blue">Save</v-btn>
                </v-form>

            </v-card-item>
        </v-card>
        <v-card class="bg-white mt-6">
            <v-card-item>
                <v-row>
                    <v-col>
                        <p>Change password</p>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="5">
                        <v-text-field variant="outlined" label="Current password" color="blue"></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="5">
                        <v-text-field variant="outlined" label="New password" color="blue" ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="5">
                        <v-text-field variant="outlined" label="Confirm new password" color="blue"></v-text-field>
                    </v-col>
                </v-row>
                <v-btn rounded="pill" class="text-none" color="blue">Save</v-btn>
            </v-card-item>
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

