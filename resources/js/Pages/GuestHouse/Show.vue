<script setup>

    import Layout from '../../shared/Layout.vue'
    import {defineProps, ref} from 'vue'
    import NavigationDrawer from '../../components/NavigationDrawer.vue'
    import RatingCard from '../../components/RatingCard.vue';

    const overlay = ref(false)
    const guesthouse = defineProps(['guesthouse', 'ratings', 'averageRating'])
    const rating = ref(4)
    const colors = ['red', 'orange', 'grey', 'cyan', 'green']
    const labels = ['bad', 'so so', 'ok', 'good', 'great']
    const images = []
    const guestHouseImg = guesthouse.guesthouse.room_image.split(",")

    guestHouseImg.forEach(img => {
        images.push(img)
    });

    const imageLayout = [
    { cols: 4 },
    {
      cols: 8,
      children: [{ cols: 12 }, { cols: 12 }],
    },
    { cols: 6 },
    { cols: 3 },
    { cols: 9 },
    { cols: 4 },
    { cols: 8 },
  ]

  function getBorderRadius(i) {
    if(i === 2) {
        return 'rounded-te-xl'
    }
    if(i === 4) {
        return 'rounded-be-xl'
    }
    
  }


</script>

<template>
        <Layout>
            <template #default>
            <v-container>
                <v-row>
                    <v-col>
                        <h1>{{ guesthouse.guesthouse.room_name }}</h1>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="2"> <v-icon color="orange-lighten-2">mdi-star</v-icon> {{ guesthouse.averageRating }} reviews</v-col>
                    <v-col cols="5"> <v-icon color="red">mdi-map-marker</v-icon> Located in - {{ guesthouse.guesthouse.room_location }}</v-col>
                </v-row>
                <v-container>
                    <v-row>
                    <v-col cols="6">
                        <v-img cover height="100%" class="rounded-s-xl" :src="`../images/${images[0]}`">
                            <template v-slot:placeholder>
                                <div class="d-flex align-center justify-center fill-height">
                                    <v-progress-circular
                                    color="grey-lighten-4"
                                    indeterminate
                                    ></v-progress-circular>
                                </div>
                            </template>
                        </v-img>
                    </v-col>
                    <v-col cols="6">
                        <v-row>
                            <v-col cols="6" v-for="i in 4" :key="i">
                                <v-img cover :src="`../images/${images[i]}`" height="100%" :class="getBorderRadius(i)">
                                    <v-btn id="showAllBtn" @click="overlay = true" v-if="i === 2" flat size="small" prepend-icon="mdi-image-multiple-outline" >show all images</v-btn>
                                    <template v-slot:placeholder>
                                        <div class="d-flex align-center justify-center fill-height">
                                            <v-progress-circular
                                            color="grey-lighten-4"
                                            indeterminate
                                            ></v-progress-circular>
                                        </div>
                                    </template>
                                </v-img>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                </v-container>
                <v-divider/>
                <v-row>
                    <v-col cols="8">
                        <v-container>
                            <h2>About this place</h2>
                            <ul>
                                <li>{{ guesthouse.guesthouse.room_details }}</li>
                                <li>{{ guesthouse.guesthouse.room_location }}</li>
                            </ul>
                        </v-container>
                        <v-divider/>
                        <v-container>
                            <h2>Rate this place</h2>
                            <p style="color: gray">Tell others what you think.</p>
                            <div class="ms-3 mt-3">
                                <v-rating
                                v-model="rating"
                                :item-labels="labels"
                                hover
                                half-increments
                                color="orange-lighten-2"
                                >
                                <template v-slot:item-label="props">
                                    <span
                                    class="font-weight-black text-caption"
                                    :class="`text-${colors[props.index]}`"
                                    >
                                    {{ props.label }}
                                    </span>
                                </template>
                                </v-rating>
                            </div>
                        </v-container>
                        <v-divider/>
                        <v-container>
                                <h2>Ratings and reviews</h2>
                                <v-row>
                                    <v-col cols="6" v-for="n in 4" :key="n">
                                        <RatingCard/>
                                    </v-col>
                                </v-row>
                        </v-container>
                    </v-col>
                    <v-col cols="4" class="mt-3">
                        <v-hover
                            v-slot="{ isHovering, props }"
                            open-delay="200"
                        >
                        <v-card
                            :elevation="isHovering ? 16 : 2"
                            :class="{ 'on-hover': isHovering }"
                            v-bind="props"
                        >
                            <v-card-title>
                                <h2>Price Details</h2>
                            </v-card-title>
                            <v-card-item>
                                <v-row>
                                    <v-col>Monthly Fee</v-col>
                                    <v-col>P {{ guesthouse.guesthouse.room_price }}</v-col>
                                </v-row>
                            </v-card-item>
                            <v-card-item>
                                <v-btn color="green" width="100%">Reserve now</v-btn>
                            </v-card-item>
                        </v-card>
                        </v-hover>
                    </v-col>
                </v-row>
                
                <NavigationDrawer @closeOverlay="overlay = false" v-if="true" :overlay="overlay" :images="images" />

            </v-container>
        </template>
        </Layout>
        
</template>

<style scoped>

    #showAllBtn {
        right: 0; 
        margin-top: 5px; 
        margin-right: 10px; 
        position: absolute; 
        opacity: 0.8;
    }



</style>