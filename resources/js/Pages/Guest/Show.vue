<script setup>

    import Layout from '../../shared/GuestLayout.vue'
    import {defineProps, ref, watch, onMounted} from 'vue'
    import { useForm } from '@inertiajs/vue3'
    import { useDate } from 'vuetify/labs/date'
    import RatingCard from '../Guest/Partials/RatingCard.vue'
    import RatingModal from '../Guest/Partials/RatingModal.vue'
    import Map from '../Guest/Partials/ShowMap.vue'
    import {format} from 'date-fns'
    import {processImages} from '@/utils/imageUtils'
    import MazGallery from 'maz-ui/components/MazGallery'
    
    defineOptions({layout: Layout})

    const props = defineProps(['guesthouse', 'ratings', 'averageRating', 'wishlist', 'auth', 'rated', 'owner'])
    const rating = ref(0)
    const discount = ref(200)
    const showReviewModal = ref(false)
    const saveWishlistForm = useForm({
        user_id: props.auth ? props.auth.user.id : '',
        room_id: props.auth ? props.guesthouse.id : '',
    })

    const images = processImages(props.guesthouse.images)
    const guesthouseImages = images.map(img => '../images/' + img)

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

    const amenities = JSON.parse(props.guesthouse.amenities)
    const reservationDate = ref(null)
    const date = useDate()
    const reserveFormAlert = ref(false)
    
    const reserveForm = useForm({
        checkin: null,
        checkout: null,
        guests: 1,
        days: null,
    })

    watch(reservationDate, () => {
        reserveForm.checkin = date.format(reservationDate.value[0], 'keyboardDate')
        reserveForm.checkout = date.format(reservationDate.value[1], 'keyboardDate')
        reserveForm.days = reservationDate ? Math.abs((new Date(reserveForm.checkin) - new Date(reserveForm.checkout)) / (1000 * 3600 * 24)) : null
        reserveFormAlert.value = false
    })

    const loading = ref(true)
    onMounted(() => {
        setTimeout(() => {
            loading.value = false
        },1000)
    })


    const submitReservation = () => {
        if(reserveForm.checkin && reserveForm.checkout) {
            reserveForm.get(`/payment/${props.guesthouse.id}`)
        }
        else {
            reserveFormAlert.value = true
        }
    }
    

</script>


<template>
    <Head :title="`${guesthouse.title}`" />
    
    <v-container>
        <h1>{{ guesthouse.title }}</h1>
        
        <v-row>
            <!-- ratings and location  -->
            <v-col cols="2"> 
                <v-icon color="orange-lighten-2">mdi-star</v-icon> {{ averageRating }} - ({{ ratings.length }} reviews) 
            </v-col>
            <v-col cols="8"> 
                <v-icon color="red">mdi-map-marker</v-icon> {{ guesthouse.location }}
            </v-col>
            <v-spacer></v-spacer>
            <v-col class="text-end">
                <!-- Save guest house button -->
                <v-form @submit.prevent="submitForm">
                    <v-btn 
                        class="text-none" 
                        :loading="saveWishlistForm.processing" 
                        type="submit"
                        rounded 
                        flat 
                        :prepend-icon="wishlist ? 'mdi-heart' : 'mdi-heart-outline'"
                        >
                            <template v-slot:prepend v-if="wishlist">
                                <v-icon color="red"></v-icon>
                            </template>
                            {{ wishlist ? 'Saved' : 'Save' }}
                    </v-btn>
                </v-form>
            </v-col>
        </v-row>
            <MazGallery :images="guesthouseImages" :height="400" class="mt-1" />
        <v-divider class="mt-2" />
        <v-row>
            <v-col cols="8">
                <!-- Guest house details -->
                    <v-list>
                        <v-list-item>
                            <template v-slot:append>
                                <v-avatar size="90" id="avatar">
                                    <v-img :src="`../images/profile/${owner.profile_pic}`"></v-img>
                                </v-avatar>
                            </template>
                            <p class="text-h5">Guest house owned by {{ owner.firstname + ' ' + owner.lastname }}</p>
                            <p class="text-grey-darken-1"> {{ guesthouse.guests }} guests - {{ guesthouse.rooms }} room - {{ guesthouse.beds }} bedroom - {{ guesthouse.bathrooms }} bathroom </p>
                        </v-list-item>
                        <v-divider class="my-2" />
                        <v-list-item prepend-icon="mdi-information-variant">
                            {{ guesthouse.description }}
                        </v-list-item>
                        <v-list-item prepend-icon="mdi-map-marker">
                            {{ guesthouse.location }}
                        </v-list-item>
                    </v-list>

                <v-divider class="my-5" />

                <!-- Place offers -->
                <v-container  class="bg-grey-lighten-3">
                    <v-list-item>
                        <p class="text-h5">Offered amenities</p>
                    </v-list-item>
                    <v-divider class="my-2" />
                    <v-row>
                        <v-col cols="6" v-for="item in amenities" :key="item">
                            <v-list-item :prepend-icon="`${item.icon}`">
                                {{ item.title }}
                            </v-list-item>
                        </v-col>
                    </v-row>  
                </v-container>

                <v-divider class="my-5" />
                
                <!-- Rate this place section -->
                <v-container class="bg-white ">
                    <p class="text-h5 font-weight-medium">Rate this place </p>
                    <p style="color: gray">Tell others what you think.</p>
                    <v-divider class="my-3" />
                    <div v-if="rated">
                        <RatingCard :rating="rated" />
                    </div>
                    <div class="ms-3 mt-3" v-else>
                        <v-rating v-model="rating" hover half-increments color="orange-lighten-2" @click="showReviewModal = true">
                        </v-rating>
                    </div>
                </v-container>
                
            </v-col>
            <v-col cols="4" class="mt-3">
                <!-- Check in checkout and Reserve button section -->
                <v-card id="reserveBtn" class="rounded-xl" elevation="5">
                    <form>
                    <v-card-item>
                        <v-row>
                            <v-col>
                                <span class="text-h6">₱{{ guesthouse.price }}</span> daily
                                <v-menu min-width="200px" rounded  :close-on-content-click="false">
                                    <template v-slot:activator="{ props }">
                                        <v-row>
                                            <v-col cols="6">
                                                <v-list-item title="Check-in" :style="reserveFormAlert ? 'border-color: red;' : 'border-color: grey;'" name="checkin" id="date" :subtitle="reservationDate ? reserveForm.checkin : 'Add date'" v-bind="props"></v-list-item>
                                            </v-col>
                                            <v-col cols="6">
                                                <v-list-item title="Check-out" :style="reserveFormAlert ? 'border-color: red;' : 'border-color: grey;'" name="checkout" id="date" :subtitle="reservationDate ? reserveForm.checkout : 'Add date'" v-bind="props"></v-list-item>
                                            </v-col>
                                        </v-row>
                                        <v-btn id="menu-activator" variant="outlined" width="100%" size="large" style="border-color: grey" class="mt-2 text-none" append-icon="mdi-chevron-down">
                                            {{ reserveForm.guests }} Guests
                                        </v-btn>
                                        <v-alert variant="outlined" type="warning" class="mt-5" prominent v-model="reserveFormAlert">
                                            <p class="font-weight-bold">Let's try that again</p>
                                            <p>Please input your checkin and checkout dates.</p>
                                        </v-alert>
                                        <v-menu activator="#menu-activator" :close-on-content-click="false">
                                            <v-list>
                                                <v-list-item title="Adults" subtitle="Age 13+">
                                                    <template v-slot:append>
                                                        <v-btn icon="mdi-plus" flat size="small" @click="reserveForm.guests++" ></v-btn>
                                                        <span class="mx-1">0</span> 
                                                        <v-btn icon="mdi-minus" flat size="small" @click="reserveForm.guests--"> </v-btn>
                                                    </template>
                                                </v-list-item>
                                                <v-list-item title="Children" subtitle="Age 2 - 12">
                                                    <template v-slot:append>
                                                        <v-btn icon="mdi-plus" flat size="small" @click="reserveForm.guests++" ></v-btn>
                                                        <span class="mx-1">0</span> 
                                                        <v-btn icon="mdi-minus" flat size="small" @click="reserveForm.guests--"> </v-btn>
                                                    </template>
                                                    
                                                </v-list-item>
                                                <v-list-item title="Inftans" subtitle="Age under 2">
                                                    <template v-slot:append>
                                                        <v-btn icon="mdi-plus" flat size="small" @click="reserveForm.guests++" ></v-btn>
                                                        <span class="mx-1">0</span> 
                                                        <v-btn icon="mdi-minus" flat size="small" @click="reserveForm.guests--"> </v-btn>
                                                    </template>
                                                </v-list-item>
                                                <v-list-item title="Pets" subtitle="bruh">
                                                    <template v-slot:append>
                                                        <v-btn icon="mdi-plus" flat size="small" @click="reserveForm.guests++" ></v-btn>
                                                        <span class="mx-1">0</span> 
                                                        <v-btn icon="mdi-minus" flat size="small" @click="reserveForm.guests--"> </v-btn>
                                                    </template>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </template>
                                    <v-card width="360">
                                        <v-date-picker color="blue" :landscape="true" width="500" show-adjacent-months multiple v-model="reservationDate"></v-date-picker>
                                    </v-card>
                                </v-menu>
                                <!-- <v-select variant="outlined" class="mt-3"></v-select> -->
                            </v-col>
                        </v-row>
                    </v-card-item>
                        <v-list v-if="reservationDate">
                            <v-list-item>
                        {{ `₱ ${guesthouse.price} x ${reserveForm.days} daily` }}
                            <template v-slot:append>
                                {{ `₱${guesthouse.price * reserveForm.days}`  }}
                            </template>
                        </v-list-item>
                        <v-list-item>
                            some discount?
                            <template v-slot:append>
                                {{`₱${discount}`}}
                            </template>
                        </v-list-item>
                        <v-divider/>
                        <v-list-item class="font-weight-bold">
                            <p>Total</p>
                            <template v-slot:append>
                                {{ `₱${(guesthouse.price * reserveForm.days) - discount}`  }}
                            </template>
                        </v-list-item>
                        </v-list>
                    <v-card-item>
                        <!-- <Link  :href=" reserveForm.date ? `/payment/${guesthouse.id}?guests=${reserveForm.guests}&checkin=${reserveForm.date[0]}&checkout=${reserveForm.date[1]}` : ''"> -->
                            <v-btn color="green" @click="submitReservation" :disabled="reserveForm.processing" :loading="reserveForm.processing" class="text-none mb-4" width="100%" size="large">Reserve</v-btn>
                        <!-- </Link> -->
                    </v-card-item>
                    </form>
                </v-card>
            </v-col>
            <v-divider class="mb-5" />
            <!-- Ratings and reviews section -->
            <v-container class="mb-5 bg-white ">
                <p class="text-h5 font-weight-medium">Ratings and reviews</p>
                <v-divider class="mt-3" />
                <v-row>
                    <v-col cols="6" class="mt-3" v-for="rating in ratings" :key="rating.id">
                        <RatingCard :rating="rating" />
                    </v-col>
                        <p class="ms-6 my-5" v-if="ratings.length <= 0">No reviews found.</p>
                </v-row>
            </v-container>
        </v-row>
        <v-divider class="mt-5" />

         <!-- MAP SECTION -->
        <v-container>
            <p class="text-h5 font-weight-medium mb-6">Where you'll be.</p>
            <Map :latitude="guesthouse.latitude" :longitude="guesthouse.longitude" />
        </v-container>
        <v-divider class="mb-5" />
        <!-- HOUSE RULES -->
        <v-container class="bg-white">
            <p class="text-h5 font-weight-medium mb-6">House rules</p>
            <v-divider />
            <v-list>
                <v-list-item prepend-icon="mdi-circle-medium"> Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sit ipsum repellat eaque. </v-list-item>
                <v-list-item prepend-icon="mdi-circle-medium">No smoking.</v-list-item>
                <v-list-item prepend-icon="mdi-circle-medium">No parties/events.</v-list-item>
                <v-list-item prepend-icon="mdi-circle-medium">No pets allowed.</v-list-item>
                <v-list-item prepend-icon="mdi-circle-medium"> 
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nihil aperiam quam,
                    assumenda optio sed autem dicta quisquam! Repellat illum vitae sint asperiores corporis modi 
                    eveniet debitis exercitationem magnam dignissimos eius, repellendus, quis officiis nam iure! </v-list-item>
            </v-list>
        </v-container>
        <v-divider class="my-5" />

        <!-- CONTACT OWNER SECTION -->
        <v-container class="bg-white">
            <v-list-item>
                <template v-slot:prepend>
                    <v-avatar size="90" id="avatar">
                        <v-img :src="`../images/profile/${owner.profile_pic}`"></v-img>
                    </v-avatar>
                </template>
                <p class="text-h5">Guest house owned by {{ owner.firstname + ' ' + owner.lastname }}</p>
                <p class="text-grey-darken-2">Joined on {{ format(new Date(owner.created_at), 'MMMM dd, yyyy') }}</p>
            </v-list-item>
            <v-list height="100%">
                <v-list-item prepend-icon="mdi-home" :title="`Lives in ${owner.address}`">
                </v-list-item>
                
                <v-list-item prepend-icon="mdi-facebook-messenger">
                    {{ owner.firstname + ' ' + owner.lastname }}
                </v-list-item>
                <v-list-item prepend-icon="mdi-phone" subtitle="Contact number" :title="`${owner.contact_no}`">
                </v-list-item>
                <v-list-item>
                    <Link :href="`/profile/${owner.id}`">
                        <v-btn class="text-none" color="blue">Contact owner</v-btn>
                    </Link>
                </v-list-item>
            </v-list>
        </v-container>
                <!-- About this place section -->
        <!-- Components -->
        <RatingModal :showReviewModal="showReviewModal" :auth="auth" :star="rating" :guesthouse="guesthouse" @closeReviewModal="showReviewModal = false" />
    </v-container>
</template>

<style scoped>

    #showAllBtn {
        right: 0;
        top: 0;
        margin-top: 10px;
        margin-right: 5%; 
        position: absolute; 
        opacity: 0.8;
        z-index: 999;
    }

    #date {
        border: 1px solid black; 
        border-radius: 10px; 
    }
    .v-card.on-hover {
        opacity: 0.8;
    }

    #reserveBtn {
        position: sticky;
        top: 130px;
    }

</style>