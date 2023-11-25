<script setup>

    import {Link} from '@inertiajs/vue3'

    const statusColor = new Map([
        ['For approval', 'text-orange'],
        ['Available', 'text-green'],
        ['Not available', 'text-red'],
        ['Rejected', 'text-red'],
    ])

    const prop = defineProps({
        listing: Object,
        latitude: Number,
        longitude: Number
    })
    const images = JSON.parse(prop.listing.images)

</script>

<template>
    <div id="carousel">
        <v-card border class="rounded-lg">
            <v-carousel :cycle="false" height="100%" hide-delimiter-background hide-delimiters show-arrows="hover">
                <v-carousel-item v-for="(image, i) in images" :key="i">
                    <Link :href="`/owner/edit-listing/${prop.listing.id}`">
                        <v-img id="carousel" :src="`/images/uploads/${images[i]}`" cover height="275" width="100%" class="rounded-t-lg">
                            <template v-slot:placeholder>
                                <div class="d-flex align-center justify-center fill-height bg-grey">
                                    <v-progress-circular color="grey-lighten-4" indeterminate>

                                    </v-progress-circular>
                                </div>
                            </template>
                        </v-img>
                    </Link>
                </v-carousel-item>
            </v-carousel>
                <v-list-item width="100%" class="bg-white">
                    <template v-slot:append v-if="listing.status == 'Approved'">
                        <v-icon color="orange-lighten-1">
                            mdi-star
                        </v-icon>
                        {{ prop.listing.averageRating == 0 ? ' New!' : listing.averageRating }} 
                    </template>
                    <strong class="truncate-text-title">{{ prop.listing.title }} </strong>
                </v-list-item>

                <v-list-item class="truncate-text bg-white" width="100%">
                    <span :class="statusColor.get(listing.status)">{{ listing.status }}</span>
                </v-list-item>
        
        </v-card>
    </div>
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