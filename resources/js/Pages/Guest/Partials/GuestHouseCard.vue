<script setup>

    import {ref, defineProps, onMounted} from 'vue'
    import {Link} from '@inertiajs/vue3'
    import { VSkeletonLoader } from 'vuetify/lib/labs/components.mjs';
    import getDistance from 'geolib/es/getDistance'
    import {processImages} from '@/utils/imageUtils'

    const prop = defineProps({
        listing: Object,
        latitude: Number,
        longitude: Number
    })
    const loading = ref(true)
    let myLocation = { latitude:  prop.latitude , longitude:  prop.longitude}
    let listingLocation = { latitude: prop.listing.latitude, longitude: prop.listing.longitude }
    
    const images = processImages(prop.listing.images)
    onMounted(() => {
        setTimeout(() => {
            loading.value = false
        },1000)
    })

</script>

<template>
    <v-card id="carousel" class="rounded-lg border">
        <v-skeleton-loader class="bg-grey-lighten-3" :loading="loading"  height="100%">
            <v-carousel :cycle="false" height="100%" hide-delimiter-background hide-delimiters="hover" show-arrows="hover">
                <v-carousel-item v-for="(image, i) in images" :key="i">
                    <Link :href="`/room/${prop.listing.id}`">
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
            <v-container class="bg-white">
                <v-row id="listingDetails">
                    <v-col cols="9"><strong class="truncate-text-title text-h6 font-weight-bold">{{ prop.listing.title }} </strong></v-col>
                    <v-col cols="3" >
                        <v-chip color="warning" prepend-icon="mdi-star-outline" text-color="white" size="small">
                            {{ prop.listing.averageRating }}
                        </v-chip>
                    </v-col>
                </v-row>
                <!-- <p class="truncate-text">{{ prop.listing.description }}</p> -->
                <p>
                    <v-icon color="red-lighten-1">mdi-map-marker</v-icon> {{ prop.listing.location }} 
                    <span class="text-grey-darken-3">
                        {{ prop.latitude && prop.longitude ? '- ' + Math.floor(getDistance({latitude: 10.250778, longitude: 123.939834}, listingLocation)/1000) + ' km away' : '' }}
                    </span>

                </p>
                <p> <strong class="text-h6">₱{{ parseInt(prop.listing.price).toLocaleString() }}</strong> <span class="text-grey-darken-3">/ daily</span> </p>
                <v-chip class="ma-2 text-grey-darken-3" prepend-icon="mdi-bed" size="small" >
                    {{ prop.listing.beds }}  Beds
                </v-chip>
                <v-chip class="ma-2 text-grey-darken-3" prepend-icon="mdi-account-multiple" size="small">
                    {{ prop.listing.guests }} Guests
                </v-chip>
                <v-chip class="ma-2 text-grey-darken-3" size="small" prepend-icon="mdi-shower">
                    {{ prop.listing.bathrooms }} Bathrooms
                </v-chip>
            </v-container>
        </v-skeleton-loader>
    </v-card>
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

  #listingDetails{
    text-decoration: none;
  }

</style>