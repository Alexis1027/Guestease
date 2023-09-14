<script setup>

    import Layout from '../../shared/Layout.vue';

    defineOptions({
        layout: Layout
    })

    const {guesthouse} = defineProps(['guesthouse'])

    const images = []
    const guestHouseImg = guesthouse.images.split(",")
    guestHouseImg.forEach(img => {
        images.push(img)
    });

</script>
<template>

    <v-container class="bg-white">
        <v-row justify="center" align="center">
            <v-col cols="7">

                <p class="font-weight-bold text-h5">Key details to take care of</p>

                <v-list-item class="my-6" title="Create your listing">
                    <p class="font-weight-bold">
                        <v-icon color="green" size="20">mdi-check-circle</v-icon> 
                        Complete
                    </p>
                </v-list-item>
                <v-divider />
                <v-list-item class="my-6" title="Verify your identity">
                    <template v-slot:append>
                        <v-btn flat icon="mdi-chevron-right"></v-btn>
                    </template>
                    <p class="text-grey-darken-2">This is a simple way to help guests feel confident booking your place.</p>
                    <p class="font-weight-bold">Required</p>
                </v-list-item>
                <v-divider />
                <v-list-item class="mt-6" title="Confirm your email address">
                    <template v-slot:append>
                        <v-btn flat icon="mdi-chevron-right"></v-btn>
                    </template>
                    <p class="text-grey-darken-2">We'll email you to confirm your email address.</p>
                    <p class="font-weight-bold">Required</p>
                </v-list-item>
            </v-col>
            <v-divider vertical/>
            <v-col cols="4" class="d-flex ms-6">

                <v-card variant="outlined" color="grey" class="rounded-xl">
                    <v-img :src="`../../images/${images[0]}`"></v-img>
                    <v-card-text class="text-black">
                        <p class="font-weight-bold">{{ guesthouse.title }}</p>
                    <p>{{ guesthouse.location }}</p>
                    </v-card-text>
                </v-card>

            </v-col>

        </v-row>

        <v-row justify="end">
            <v-btn class="text-none me-6" size="large" color="blue">Publish listing</v-btn>
        </v-row>
    </v-container>

</template>

<style scoped>

    .v-row{
        margin-top: 3%;
    }
.v-container {
        height: 80vh;
    }

</style>