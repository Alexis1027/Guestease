<script setup>

    import {ref, defineProps, onMounted} from 'vue'
    import {Link} from '@inertiajs/vue3'
    import { VSkeletonLoader } from 'vuetify/lib/labs/components.mjs';
    import getDistance from 'geolib/es/getDistance'

    const prop = defineProps({
        guesthouse: Object,
        latitude: Number,
        longitude: Number
    })
   

    // const distance = ref()
    // const myLocation = { latitude:  prop.latitude , longitude:  prop.longitude}
    // const guesthouseLocation = { latitude: prop.guesthouse.latitude, longitude: prop.guesthouse.longitude }
    // distance.value = getDistance(myLocation, guesthouseLocation)
    // console.log(myLocation)
    // console.log(guesthouseLocation)
    // console.log(getDistance(myLocation, guesthouseLocation))
    

    const images = []
    const guestHouseImg = prop.guesthouse.room_image.split(",")
    const loading = ref(true)
    guestHouseImg.forEach(img => {
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
                    <Link :href="`/room/${prop.guesthouse.id}`">
                        <v-img id="carousel" :src="`images/${images[i]}`" cover height="275" width="100%" class="rounded-t-lg">
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
            <v-container class="bg-grey-lighten-3">
                <v-row id="guestHouseDetails">
                <v-col cols="8"><strong class="truncate-text-title">{{ prop.guesthouse.room_name }} </strong></v-col>
                <v-col cols="4" >
                    <v-icon color="orange-lighten-1">
                        mdi-star
                    </v-icon>
                    {{ prop.guesthouse.averageRating }} 
                </v-col>
            </v-row>
            <p class="truncate-text">{{ prop.guesthouse.room_details }}</p>
            <p> <strong>P {{ prop.guesthouse.room_price }}</strong> monthly. </p>
            </v-container>
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
      -webkit-line-clamp: 1; /* Adjust the number of lines to show */
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
    }

  #guestHouseDetails{
    text-decoration: none;
  }

</style>