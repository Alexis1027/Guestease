<script setup>

    import {ref, defineProps, onMounted} from 'vue'
    import {Link} from '@inertiajs/vue3'
    import { VSkeletonLoader } from 'vuetify/lib/labs/components.mjs';

    const prop = defineProps({
        listing: Object,
        latitude: Number,
        longitude: Number
    })
    const loading = ref(true)

    onMounted(() => {
        setTimeout(() => {
            loading.value = false
        },1000)
    })
    
    const images = JSON.parse(prop.listing.images)

</script>

<template>
    <div id="carousel">
        {{ images.length }}
        <v-card border :color="listing.status == 'approved' ? '' : 'red'" class="rounded-lg">
            <v-skeleton-loader :loading="loading"  height="100%">
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
                <v-list-item width="100%" class="bg-white">
                    <template v-slot:append v-if="listing.status == 'approved'">
                        <v-icon color="orange-lighten-1">
                            mdi-star
                        </v-icon>
                        {{ prop.listing.averageRating == 0 ? ' New!' : listing.averageRating }} 
                    </template>
                    <template v-slot:append v-else>
                        <v-icon color="red">
                            mdi-alert-circle
                        </v-icon>
                    </template>
                    <strong class="truncate-text-title">{{ prop.listing.title }} </strong>
                </v-list-item>

                <v-list-item class="truncate-text bg-white" width="100%">
                    <span :class="listing.status == 'approved' ? 'text-green' : 'text-error'">{{ listing.status }}</span>
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