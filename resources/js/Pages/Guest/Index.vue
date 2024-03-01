<script setup>

    import GuestHouseCard from './Partials/ListingCard.vue';
    import GuestLayout from '../../Layouts/GuestLayout.vue';
    defineOptions({layout: GuestLayout})
    import {defineProps, ref} from 'vue'
    const props = defineProps(['listings'])
    
    const latitude = ref()
    const longitude = ref()
    navigator.geolocation.getCurrentPosition((pos) => {
        latitude.value = pos.coords.latitude
        longitude.value = pos.coords.longitude
    }, error => {
        console.log(error)
    })

</script>

<template>
    <Head title="Home" />
    <!-- <div class="page-container"> -->
        <p class="text-h6 my-5 text-center" v-if="listings.length <= 0">No listings found.</p>
        <v-row class="ma-2">
            <v-col cols="12" sm="6" md="3" lg="3" v-for="listing in props.listings" :key="listing.id">
                <GuestHouseCard :listing="listing" :latitude="latitude" :longitude="longitude" />
            </v-col>
        </v-row>
        <div class="sticky-btn-container">
            <Link href="/map">
            <v-btn class="rounded-pill" color="blue" elevation="24" size="large" prepend-icon="mdi-map-search-outline">Show Map</v-btn>
            </Link>
        </div>
    <!-- </div> -->
  </template>
  
  <style scoped>
  .sticky-btn-container {
    position: sticky;
    bottom: 0;  
    right: 0; 
    z-index: 1000; 
    justify-content: center;
    display: flex;
  }
  .v-btn {
    margin-bottom: 30px;
  }
  
  </style>
  