<script setup>

    import GuestLayout from '../Layouts/GuestLayout.vue'
    import Footer from '../Layouts/Footer.vue'
    defineOptions({layout: GuestLayout})

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
            <v-card  width="100%" elevation="20" title="Get in touch">
                <v-card-item>
                    <v-row>
                        <v-col cols="6">
                            <v-text-field color="blue" label="First name"></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field color="blue" label="Last name"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-text-field color="blue" label="Email"></v-text-field>
                    <v-textarea color="blue" label="What can we help you with?"></v-textarea>
                </v-card-item>
                <v-card-actions>
                    <v-btn color="blue">Submit</v-btn>
                </v-card-actions>
            </v-card>
        </v-col>

    </v-row>

    <Footer />

</template>

