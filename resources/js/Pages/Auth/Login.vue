<script setup>

    import {ref} from 'vue'
    import Layout from '../../shared/Layout.vue';

    const loginEmail = ref('')
    const loginPassword = ref('')
    const regEmail = ref('')
    const regFirstname = ref('')
    const regLastname = ref('')
    const regPassword = ref('')
    const regConfirmPassword = ref('')

    const tab = ref(null)

    const loginEmailRules = [
        value => {
            if (/^[a-z.-]+@[a-z.-]+\.[a-z]+$/i.test(value)) return true

            return 'Must be a valid e-mail.'
        }
    ]

    const loginPasswordRules = [
        value => {
            if (value) return true

            return 'Must enter a password.'
        }
    ]

    const regEmailRules = [
        value => {
                if (/^[a-z.-]+@[a-z.-]+\.[a-z]+$/i.test(value)) return true

                return 'Must be a valid e-mail.'
            }
    ]

    const regFirstnameRules = [
        value => {
            if (value?.length >= 3) return true
            return 'First name needs to be at least 3 characters.'
            }
    ]

    const regLastnameRules = [
        value => {
            if (value?.length >= 3) return true
            return 'Last name needs to be at least 3 characters.'
        }
    ]

    const regPasswordRules = [
        value => {
            if(value?.length >= 3) return true
            return 'Password needs to be at least 3 characters.'
        }
    ]

</script>
<template>
    <Layout>
        <template #default>
           
        <v-container class="justify-center d-flex">
            <v-card width="50%">
                <v-tabs v-model="tab" bg-color="green-lighten-2" centered>
                    <v-tab value="tab-1">
                        Login
                    </v-tab>

                    <v-tab value="tab-2">
                        Register
                    </v-tab>
                </v-tabs>

                <v-window v-model="tab">

                    <v-window-item value="tab-1">
                            <v-card>
                                <v-card-title class="text-center">Get started!</v-card-title>
                                <v-card-item>
                                    <v-text-field label="Email" type="email" :rules="loginEmailRules" v-model="loginEmail" />
                                    <v-text-field label="Password" type="password" :rules="loginPasswordRules" v-model="loginPassword" />
                                    <a href="">Forgot password?</a>
                                </v-card-item>
                                <v-card-actions class="justify-end">
                                    <v-btn class="bg-green" width="100%">Login</v-btn>
                                </v-card-actions>
                            </v-card>
                    </v-window-item>

                    <v-window-item value="tab-2">
                            <v-card>
                                <v-card-title class="text-center">Register with us!</v-card-title>
                                <v-card-item>
                                    <v-text-field label="Email" :rules="regEmailRules" v-model="regEmail" />
                                    <v-text-field label="First name" :rules="regFirstnameRules" v-model="regFirstname" />
                                    <v-text-field label="Last name" :rules="regLastnameRules" v-model="regLastname" />
                                    <v-text-field label="Password" :rules="regPasswordRules" v-model="regPassword" />
                                    <v-text-field label="Confirm password" v-model="regConfirmPassword"/>
                                </v-card-item>
                                <v-card-actions class="justify-end">
                                    <v-btn class="bg-green" width="100%">Register</v-btn>
                                </v-card-actions>
                            </v-card>
                    </v-window-item>
                </v-window>
            </v-card>
        </v-container>
        </template>
    </Layout>
</template>