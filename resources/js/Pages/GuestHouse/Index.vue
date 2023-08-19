<script setup>

    import GuestHouseCard from '../../components/GuestHouseCard.vue';
    import Layout from '../../shared/Layout.vue';
    import {defineProps} from 'vue'
    defineOptions({layout: Layout})
    const guesthouses = defineProps(['guesthouses'])
</script>


<template>
    <Head title="Home" />
    <div class="page-container">
      <v-row>
        <v-col cols="3" v-for="guesthouse in guesthouses.guesthouses" :key="guesthouse.id">
          <GuestHouseCard :guesthouse="guesthouse" />
        </v-col>
      </v-row>
      <div class="sticky-btn-container">
        <Link href="/map">
          <v-btn class="rounded-pill" color="blue" elevation="24" size="large" prepend-icon="mdi-map-search-outline">Show Map</v-btn>
        </Link>
      </div>
    </div>
  </template>
  
  <style scoped>
  .page-container {
    position: relative; /* Create a context for positioning */
    min-height: 100vh; /* Ensure the container takes at least the full viewport height */
    display: flex;
    flex-direction: column;
  }
  
  .sticky-btn-container {
    position: sticky;
    bottom: 0; /* Adjust this value to control the vertical position */
    right: 0; /* Adjust this value to control the horizontal position */
    z-index: 1000; /* Ensure the button appears above other content */
    justify-content: center;
    display: flex;
  }
  .v-btn {
    margin-bottom: 30px;
  }
  </style>
  