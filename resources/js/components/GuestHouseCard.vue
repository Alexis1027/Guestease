<script setup>

    import {ref, defineProps, onMounted} from 'vue'
    import {Link} from '@inertiajs/vue3'
    import { VSkeletonLoader } from 'vuetify/lib/labs/components.mjs';
    const guesthouse = defineProps(['guesthouse'])
    const images = []
    const guestHouseImg = guesthouse.guesthouse.room_image.split(",")
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
        <!-- <router-link to="/about">about...</router-link> -->
        <v-skeleton-loader class="mt-6" :loading="loading" height="100%" type="image, article">
            <v-carousel :cycle="false" height="100%" hide-delimiter-background hide-delimiters show-arrows="hover">
                <v-carousel-item v-for="(image, i) in images" :key="i">
                    <Link :href="`/room/${guesthouse.guesthouse.id}`">
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
            <v-container class="bg-grey-lighten-3">
                <v-row id="guestHouseDetails">
                <v-col cols="8"><strong class="truncate-text-title">{{ guesthouse.guesthouse.room_name }} </strong></v-col>
                <v-col cols="4" >
                    <v-icon color="orange-lighten-1">
                        mdi-star
                    </v-icon>
                    {{ guesthouse.guesthouse.averageRating }} 
                </v-col>
            </v-row>
            <p class="truncate-text">{{ guesthouse.guesthouse.room_details }}</p>
            <p> <strong>P {{ guesthouse.guesthouse.room_price }}</strong> monthly. </p>
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