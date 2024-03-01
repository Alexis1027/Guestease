<script setup>

    import GuestLayout from '../Layouts/GuestLayout.vue'
    import Footer from '../Layouts/Footer.vue'
    import {useForm} from '@inertiajs/vue3'
    import {ref} from 'vue'
    defineOptions({layout: GuestLayout})

    const snackbar = ref(false)
    const contactForm = useForm({
        name: null,
        email: null,
        message: null
    })

    function submit() {
        contactForm.post(`/send-message`,  {
            onSuccess: () => {
                snackbar.value = true
                contactForm.reset()
            }
        })
    }

</script>

<template>
    <Head title="Contact us" />
    <v-row style="margin-top: 3%;" class="mb-6">
        <v-col  cols="12" sm="12" md="6" lg="6" class="ps-5" style="margin: auto;">
            <p class="text-h3 text-blue">Contact us</p>
            <p class="text-h6 pa-5">Connect with us on our facebook page for updates and conversations.</p>
            <v-list-item subtitle="Call us" prepend-icon="mdi-phone">(+63)9123456789</v-list-item>
            <v-list-item subtitle="Location" prepend-icon="mdi-map-marker">Purok lorem ipsum, Barangay Lorem Ipsum, Cordova, Cebu</v-list-item>
            <!-- <v-list-item subtitle="Call us" prepend-icon="mdi-phone">(+63)9123456789</v-list-item> -->
         
        </v-col>
        <v-col cols="12" sm="12" md="6" lg="6" class="pa-6" style="margin: auto;">
            <v-form @submit.prevent>
                <v-card color="blue-lighten-5" width="100%" elevation="20" title="Get in touch">
                    <v-card-item>
                        <v-text-field variant="solo" color="blue" v-model="contactForm.name" :error-messages="contactForm.errors.name" label="Name"></v-text-field>
                        <v-text-field variant="solo" color="blue" v-model="contactForm.email" :error-messages="contactForm.errors.email" label="Email"></v-text-field>
                        <v-textarea variant="solo" color="blue" v-model="contactForm.message" :error-messages="contactForm.errors.message" label="What can we help you with?"></v-textarea>
                    </v-card-item>
                    <v-card-actions>
                        <v-btn color="blue" variant="flat" type="submit" @click="submit" :loading="contactForm.processing">Submit</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-col>
    </v-row>

    <v-snackbar v-model="snackbar">
        Your message has been successfully submitted. We appreciate your interest and will get back to you as soon as possible.
    </v-snackbar>

    <Footer />

</template>

