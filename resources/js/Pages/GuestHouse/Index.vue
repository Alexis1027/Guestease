<script setup>

    import GuestHouseCard from './Partials/GuestHouseCard.vue';
    import Layout from '../../shared/Layout.vue';
    import {defineProps, ref} from 'vue'
    defineOptions({layout: Layout})
    const props = defineProps(['guesthouses'])
    //TOMorrow !
    const latitude = ref()
    const longitude = ref()
    navigator.geolocation.getCurrentPosition((pos) => {
        latitude.value = pos.coords.latitude
        longitude.value = pos.coords.longitude
        console.log(pos)
    }, error => {
        console.log(error)
    })

</script>

<template>
    <Head title="Home" />
    <!-- <div class="page-container"> -->
        <h2>{{ latitude }}</h2>
        <h2>{{ longitude }}</h2>
        <v-row>
            <v-col cols="3" v-for="guesthouse in props.guesthouses" :key="guesthouse.id">
                <GuestHouseCard :guesthouse="guesthouse" :latitude="latitude" :longitude="longitude" />
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
  /* .page-container {
    position: relative;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  } */
  
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
  