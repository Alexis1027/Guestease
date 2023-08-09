<script setup>

    import {ref, defineProps} from 'vue'
    import {Link} from '@inertiajs/vue3'

    const guesthouse = defineProps(['guesthouse'])
    const images = []
    const guestHouseImg = guesthouse.guesthouse.room_image.split(",")

    guestHouseImg.forEach(img => {
        images.push(img)
    });
    
    const slides = ref([
        'First',
        'Second',
        'Third',
        'Fourth',
        'Fifth',
    ])

    const colors= ref([
        'indigo',
        'warning',
        'pink darken-2',
        'red lighten-1',
        'deep-purple accent-4',
    ])

    

</script>

<template>
    <div id="carousel">
        <!-- <router-link to="/about">about...</router-link> -->
        <v-carousel
        cycle
        height="275"
        hide-delimiter-background
        hide-delimiters
        show-arrows="hover"
        >
            <v-carousel-item
                v-for="(slide, i) in slides"
                :key="i"
            >
                <Link :href="`/room/${guesthouse.guesthouse.id}`">
                    <v-img id="carousel" :src="`images/${images[i]}`" cover height="275" class="rounded-t-lg">
                        <template v-slot:placeholder>
                            <div class="d-flex align-center justify-center fill-height">
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
        <v-row id="guestHouseDetails">
            <v-col cols="8"><strong>{{ guesthouse.guesthouse.room_name }} </strong></v-col>
            <v-col cols="4" >
                <v-icon color="orange-lighten-1">
                    mdi-star
                </v-icon>
                 {{ guesthouse.guesthouse.averageRating }} {{ guesthouse.guesthouse.id }}
            </v-col>
        </v-row>
        <p>{{ guesthouse.guesthouse.room_details }}</p>
        <p> <strong>P {{ guesthouse.guesthouse.room_price }}</strong> monthly. </p>
    </div>
  </template>

<style scoped>

  #carousel:hover{
    cursor: pointer;
  }

  #guestHouseDetails{
    text-decoration: none;
  }

</style>