<script setup>

    import AdminLayout from '../../Layouts/AdminLayout.vue'
    import {useForm} from '@inertiajs/vue3'

    const form = useForm({
        firstname: null,
        lastname: null,
        email: null,
        password: null,
        phone_number: null
    })

    defineOptions({layout: AdminLayout})

</script>


<template>
        <Head title="Create admin" />
        <v-card elevation="0" title="Create admin" width="50%">
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
                    />
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
                <v-btn block class="fadeIn third mt-4" :loading="form.processing" :disabled="form.processing" @click="form.post('/admin/create-admin')" type="submit" id="btn-login" color="blue">Create</v-btn>
            </v-card-item>
        </v-card>
</template>

