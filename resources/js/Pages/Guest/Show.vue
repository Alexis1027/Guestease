<script setup>

    import Layout from '../../shared/Layout.vue'
    import {defineProps, ref} from 'vue'
    import { useForm } from '@inertiajs/vue3'
    import ImageDrawer from '../Guest/Partials/ImageDrawer.vue'
    import RatingCard from '../Guest/Partials/RatingCard.vue'
    import ImageCarousel from '../Guest/Partials/ImageCarousel.vue'
    import RatingModal from '../Guest/Partials/RatingModal.vue'
    import Map from '../Guest/Partials/ShowMap.vue'

    defineOptions({layout: Layout})

    const overlay = ref(false)
    const props = defineProps(['guesthouse', 'ratings', 'averageRating', 'wishlist', 'auth', 'rated'])
    const rating = ref(0)
    const index = ref(0)
    const showImageCarousel = ref(false)
    const showReviewModal = ref(false)
    const images = []
    console.log(props)
    const guestHouseImg = props.guesthouse.room_image.split(",")
    const saveWishlistForm = useForm({
        user_id: props.auth ? props.auth.user.id : '',
        room_id: props.auth ? props.guesthouse.id : '',
    })

    guestHouseImg.forEach(img => {
        images.push(img)
    });

  function getBorderRadius(i) {
    if(i === 2) {
        return 'rounded-te-xl'
    }
    if(i === 4) {
        return 'rounded-be-xl'
    }
    
  }

  function showImageCarouselFunc(idx) {
    index.value = idx
    showImageCarousel.value = true
  }

  const submitForm = () => {
    if(props.wishlist) {
        saveWishlistForm.delete('/wishlist/unsave', {
            preserveScroll: true
        })
    }
    else {
        saveWishlistForm.post('/wishlist/save')
    }
  }

</script>

<template>
    <Head :title="`${props.guesthouse.room_name}`" />
    
    <v-container>
        <h1>{{ props.guesthouse.room_name }}</h1>
        <v-row>
            <!-- ratings and location  -->
            <v-col cols="2"> 
                <v-icon color="orange-lighten-2">mdi-star</v-icon> {{ props.averageRating }} - ({{ props.ratings.length }} reviews) 
            </v-col>
            <v-col cols="5"> 
                <v-icon color="red">mdi-map-marker</v-icon> Located in - {{ props.guesthouse.room_location }}
            </v-col>
            <v-spacer></v-spacer>
            <v-col class="text-end">
                <!-- Save guest house button -->
                <v-form @submit.prevent="submitForm">
                    <v-btn 
                        class="text-none bg-grey-lighten-3" 
                        :loading="saveWishlistForm.processing" 
                        type="submit"
                        rounded 
                        flat 
                        :prepend-icon="props.wishlist ? 'mdi-heart' : 'mdi-heart-outline'"
                        >
                            <template v-slot:prepend v-if="props.wishlist">
                                <v-icon color="red"></v-icon>
                            </template>
                            {{ props.wishlist ? 'Saved' : 'Save' }}
                    </v-btn>
                </v-form>
            </v-col>
        </v-row>
        <v-container>
            <v-row>
                <v-col cols="6">
                    <!-- First image -->
                    <v-hover v-slot="{ isHovering, props }">
                        <v-card height="100%" max-height="400" :elevation="isHovering ? 8 : 0" :class="{ 'on-hover': isHovering, 'bg-grey-lighten-3' : true }" v-bind="props">
                            <v-img cover height="100%" class="rounded-s-xl" :src="`../images/${images[0]}`"  @click="showImageCarouselFunc(0)">
                                <template v-slot:placeholder>
                                    <div class="d-flex align-center justify-center fill-height">
                                        <v-progress-circular color="grey-lighten-4" indeterminate>
                                        </v-progress-circular>
                                    </div>
                                </template>
                            </v-img>
                        </v-card>
                    </v-hover>
                </v-col>
                <v-col cols="6">
                    <v-row>
                        <!--  4 images -->
                        <v-col cols="6" v-for="i in 4" :key="i">
                            <v-hover v-slot="{ isHovering, props }">
                                <v-card height="100%" max-height="180" :elevation="isHovering ? 8 : 0" :class="{ 'on-hover': isHovering, 'bg-grey-lighten-3' : true }" v-bind="props">
                                    <!-- show the show all images button if i is equal to two -->
                                    <v-btn id="showAllBtn" @click="overlay = true" v-if="i === 2" size="small" prepend-icon="mdi-image-multiple-outline" class="text-none">Show all images</v-btn>

                                    <v-img cover :src="`../images/${images[i]}`" height="100%" :class="getBorderRadius(i)" @click="showImageCarouselFunc(i)">
                                        <template v-slot:placeholder>
                                            <div class="d-flex align-center justify-center fill-height">
                                                <v-progress-circular color="grey-lighten-4" indeterminate>
                                                </v-progress-circular>
                                            </div>
                                        </template>
                                    </v-img>
                                </v-card>
                            </v-hover>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-container>
        <v-divider/>
        <v-row>
            <v-col cols="8">
                <v-container>
                    <p class="text-h5 font-weight-medium">About this place</p>
                    <ul>
                        <li>{{ props.guesthouse.room_details }}</li>
                        <li>{{ props.guesthouse.room_location }}</li>
                    </ul>
                </v-container>
                <v-divider/>

                <v-container>
                    <v-list-item>
                        <template v-slot:prepend>
                            <v-avatar size="90" id="avatar">
                        <v-img src="../images/profile/21.png"></v-img>
                    </v-avatar>
                        </template>
                        <p class="text-h5">Guest house owned by 21 Savage</p>
                        <p class="text-grey-darken-2">Joined in September 2023</p>
                    </v-list-item>
                   
                    <v-list height="100%" class="bg-grey-lighten-3">
                        <v-list-item prepend-icon="mdi-home" :title="`Lives in Cordova, Cebu`">
                        </v-list-item>
                        
                        <v-list-item prepend-icon="mdi-facebook-messenger">
                            First Lastname
                        </v-list-item>
                        <v-list-item prepend-icon="mdi-phone" subtitle="Contact number" title="09123456789">
                        </v-list-item>
                        <v-list-item>
                            <Link href="/profile/1">
                                <v-btn class="text-none" color="blue">Contact owner</v-btn>
                            </Link>
                        </v-list-item>
                    </v-list>
                </v-container>
                <!-- About this place section -->
                
                <v-divider/>
                <!-- Rate this place section -->
                <v-container>
                    <p class="text-h5 font-weight-medium">Rate this place </p>
                    <p style="color: gray">Tell others what you think.</p>
                    <div v-if="props.rated" class="mt-3">
                        <RatingCard :rating="props.rated" />
                    </div>
                    <div class="ms-3 mt-3" v-else>
                        <v-rating v-model="rating" hover half-increments color="orange-lighten-2" @click="showReviewModal = true">
                        </v-rating>
                    </div>
                </v-container>
                
            </v-col>
            <v-col cols="4" class="mt-3">

                <!-- Reserve button section -->

                <v-card>
                    <v-card-title>
                        <!-- <h2>Price Details</h2> -->
                    </v-card-title>
                    <v-card-item>
                        <v-row>
                            <!-- <v-col>Monthly Fee </v-col> -->
                            <v-col>P {{ props.guesthouse.room_price }}</v-col>
                        </v-row>
                    </v-card-item>
                    <v-card-item>
                        <Link :href="`/payment/${props.guesthouse.id}`">
                            <v-btn color="green" width="100%">Reserve</v-btn>
                        </Link>
                    </v-card-item>
                </v-card>
            </v-col>
            <v-divider/>
            <!-- Ratings and reviews section -->
            <v-container class="mb-5">
                <p class="text-h5 font-weight-medium">Ratings and reviews</p>
                <v-row class="mt-3">
                    <v-col cols="6" v-for="rating in props.ratings" :key="rating.id">
                        <RatingCard :rating="rating" />
                    </v-col>
                        <p class="ms-6" v-if="props.ratings.length <= 0">No reviews found.</p>
                </v-row>
            </v-container>
        </v-row>
        <v-divider></v-divider>

        <v-container>
            <p class="text-h5 font-weight-medium mb-6">Where you'll be.</p>
            <Map :latitude="props.guesthouse.latitude" :longitude="props.guesthouse.longitude" />
        </v-container>
        <v-divider />
        <v-container>
            <p class="text-h5 font-weight-medium mb-6">Rules and regulations.</p>

        </v-container>

        <!-- Components -->

        <ImageDrawer @closeOverlay="overlay = false" v-if="true" :overlay="overlay" :images="images" />
        <ImageCarousel :showImageCarousel="showImageCarousel" :images="images" :index="index" @CloseImgCarousel="showImageCarousel = false" />
        <RatingModal :showReviewModal="showReviewModal" :auth="props.auth" :star="rating" :guesthouse="props.guesthouse" @closeReviewModal="showReviewModal = false" />
    </v-container>
</template>

<style scoped>

    #showAllBtn {
        right: 0; 
        margin-top: 5px; 
        margin-right: 10px; 
        position: absolute; 
        opacity: 0.8;
        z-index: 999;
    }

    .v-card.on-hover {
        opacity: 0.8;
    }

</style>