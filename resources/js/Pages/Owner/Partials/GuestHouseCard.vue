<script setup>

    import {ref, defineProps, onMounted} from 'vue'
    import {Link} from '@inertiajs/vue3'
    import { VSkeletonLoader } from 'vuetify/lib/labs/components.mjs';
    import getDistance from 'geolib/es/getDistance'

    const prop = defineProps({
        listing: Object,
        latitude: Number,
        longitude: Number
    })
   
    let myLocation = { latitude:  prop.latitude , longitude:  prop.longitude}
    let listingLocation = { latitude: prop.listing.latitude, longitude: prop.listing.longitude }
    
    const images = []
    const listingImg = prop.listing.images.split(",")
    const loading = ref(true)
    listingImg.forEach(img => {
        images.push(img)
    });

    onMounted(() => {
        setTimeout(() => {
            loading.value = false
        },1000)
    })
    
</script>

<template>
    <div id="carousel">
        <v-skeleton-loader class="mt-6 bg-grey-lighten-3" :loading="loading"  height="100%">
            <v-carousel :cycle="false" height="100%" hide-delimiter-background hide-delimiters show-arrows="hover">
                <v-carousel-item v-for="(image, i) in images" :key="i">
                    <Link :href="`/owner/edit-listing/${prop.listing.id}`">
                        <v-img id="carousel" :src="`../images/${images[i]}`" cover height="275" width="100%" class="rounded-t-lg">
                            <template v-slot:placeholder>
                                <div class="d-flex align-center justify-center fill-height">
                                    <v-progress-circular color="grey-lighten-4" indeterminate>

                                    </v-progress-circular>
                                </div>
                            </template>
                        </v-img>
                    </Link>
                </v-carousel-item>
            </v-carousel>
        </v-skeleton-loader>
        <v-skeleton-loader :loading="loading" class="bg-grey-lighten-3"  height="80%" type="image, article">
                <v-list-item width="100%">
                    <template v-slot:append>
                        <v-icon color="orange-lighten-1">
                            mdi-star
                        </v-icon>
                        {{ prop.listing.averageRating }} 
                    </template>
                    <strong class="truncate-text-title">{{ prop.listing.title }} </strong>
                </v-list-item>

                <v-list-item class="truncate-text" width="100%">{{ prop.listing.location }}</v-list-item>
        </v-skeleton-loader>
        
    </div>
  </template>

<style scoped>

  #carousel:hover{
    cursor: pointer;
  }

  .truncate-text {
      display: -webkit-box;
      -webkit-line-clamp: 2; /* Adjust the number of lines to show */
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .truncate-text-title {
      display: -webkit-box;
      -webkit-line-clamp: 2; /* Adjust the number of lines to show */
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
    }

  #guestHouseDetails{
    text-decoration: none;
  }

</style>