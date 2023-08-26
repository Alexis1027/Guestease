<script setup>

    import GuestHouseCard from './Partials/GuestHouseCard.vue';
    import Layout from '../../shared/Layout.vue';
    import {defineProps} from 'vue'
    defineOptions({layout: Layout})
    const props = defineProps(['guesthouses'])
</script>

<template>
    <Head title="Home" />
    <!-- <div class="page-container"> -->
        <v-row>
            <v-col cols="3" v-for="guesthouse in props.guesthouses" :key="guesthouse.id">
                <GuestHouseCard :guesthouse="guesthouse" />
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
  