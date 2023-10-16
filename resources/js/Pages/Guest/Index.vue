<script setup>

    import GuestHouseCard from '../Guest/Partials/GuestHouseCard.vue';
    import Layout from '../../Layouts/GuestLayout.vue';
    import {defineProps, ref} from 'vue'

    defineOptions({layout: Layout})
    const props = defineProps(['listings'])
    //TOMorrow !
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
        <p class="text-h4" v-if="listings.length <= 0">no listings found. pag seed ug data</p>
        <v-row>
            <v-col cols="4" v-for="listing in props.listings" :key="listing.id">
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
  