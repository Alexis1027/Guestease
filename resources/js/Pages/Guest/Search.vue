<script setup>

    import GuestLayout from '../../Layouts/GuestLayout.vue'
    import GuestHouseCard from './Partials/ListingCard.vue';

    defineOptions({layout: GuestLayout})
    defineProps({ listings: Object })

</script>

<template>
    <Head title="Home" />
    
        <v-row class="ma-2">
            <p class="text-h6 my-5 text-center" v-if="listings.length <= 0">No listings found.</p>
            <v-col cols="12" sm="6" md="4" lg="3" v-for="listing in listings" :key="listing.id">
                <GuestHouseCard :listing="listing" :latitude="latitude" :longitude="longitude" />
            </v-col>
        </v-row>
  </template>
 