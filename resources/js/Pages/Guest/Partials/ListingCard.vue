<script setup>

    import {ref, defineProps, onMounted} from 'vue'
    import {Link} from '@inertiajs/vue3'
    import getDistance from 'geolib/es/getDistance'

    const prop = defineProps({
        listing: Object,
        latitude: Number,
        longitude: Number
    })
    let listingLocation = { latitude: prop.listing.latitude, longitude: prop.listing.longitude }
    
    const images = JSON.parse(prop.listing.images)
   

</script>

<template>
    <v-card id="carousel" class="rounded-lg border">
        <v-carousel :cycle="false" height="100%" hide-delimiter-background hide-delimiters="hover" show-arrows="hover" id="carousel">
            <v-carousel-item v-for="(image, i) in images" :key="i">
                <Link :href="`/room/${listing.id}`">
                    <v-img id="carousel" :src="`images/uploads/${images[i]}`" cover height="275" width="100%" class="rounded-t-lg">
                        <template v-slot:placeholder>
                            <div class="d-flex align-center justify-center fill-height bg-grey">
                                <v-progress-circular
                                color="grey-lighten-4"
                                indeterminate
                                ></v-progress-circular>
                            </div>
                        </template>
                    </v-img>
                </Link>
            </v-carousel-item>
        </v-carousel>
        <v-card-item class="bg-white">
            <v-row id="listingDetails">
                <v-col cols="8">
                    <p class="truncate-text text-body-1 font-weight-medium">
                        {{ listing.title }} 
                    </p>
                </v-col>
                <v-col cols="4">
                    <v-chip color="warning" prepend-icon="mdi-star-outline" text-color="white" size="small" class="ms-4">
                        {{ listing.averageRating == 0 ? ' New!' : listing.averageRating }} 
                    </v-chip>
                </v-col>
            </v-row>
            <v-divider class="my-1" />
            <p>
                <span class="text-body-2 truncate-text">
                <v-icon color="red-lighten-1">mdi-map-marker</v-icon> 
                     {{ listing.location }}
                     <span class="text-grey-darken-3 text-caption">
                        {{ latitude && longitude ? ' - ' + Math.floor(getDistance({latitude: 10.250778, longitude: 123.939834}, listingLocation)/1000) + ' km away' : '' }}
                    </span>
                 </span>
                
            </p>
            <p> 
                <strong class="text-h6">
                    ₱{{ parseInt(listing.price).toLocaleString() }}
                </strong> 
                <span class="text-grey-darken-3">/ {{listing.type == 'Guest house' ? 'monthly' : 'daily'}}</span> 
            </p>
            <v-chip class="ma-2 text-grey-darken-3" prepend-icon="mdi-bed" size="small" v-if="listing.beds > 0">
                {{ listing.beds }}  Bed
            </v-chip>
            <v-chip class="ma-2 text-grey-darken-3" prepend-icon="mdi-account-multiple" size="small" v-if="listing.guests > 0">
                {{ listing.guests }} Guest
            </v-chip>
            <v-chip class="ma-2 text-grey-darken-3" size="small" prepend-icon="mdi-shower" v-if="listing.bathrooms > 0">
                {{ listing.bathrooms }} Bath
            </v-chip>
        </v-card-item>
    </v-card>
  </template>

<style scoped>

  #carousel:hover{
    cursor: pointer;
  }

  .truncate-text {
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