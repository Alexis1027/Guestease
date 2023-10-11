<script setup>

    import Layout from '../../Layouts/GuestLayout.vue'
    import {defineProps, reactive, ref, watch} from 'vue'
    import { useForm } from '@inertiajs/vue3'
    import { useDate } from 'vuetify/labs/date'
    import RatingCard from '../Guest/Partials/RatingCard.vue'
    import RatingDialog from './Partials/RatingDialog.vue'
    import Map from '../Guest/Partials/ShowMap.vue'
    import {format} from 'date-fns'
    import MazGallery from 'maz-ui/components/MazGallery'
    
    defineOptions({layout: Layout})

    const props = defineProps(['listing', 'ratings', 'averageRating', 'wishlist', 'auth', 'rated', 'owner'])
    const rating = ref(0)
    const showReviewModal = ref(false)
    const images = JSON.parse(props.listing.images)
    const listingImages = images.map(img => '../images/' + img)
    const amenities = JSON.parse(props.listing.amenities)
    const reservationDate = ref(null)
    const date = useDate()
    const reserveFormAlert = ref(false)
    const guests = reactive({
        adults: 1,
        children: 0,
        infants: 0,
        pets: 0,
    })

    const saveWishlistForm = useForm({
        user_id: props.auth ? props.auth.user.id : '',
        listing_id: props.auth ? props.listing.id : '',
    })

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

    const submitReservation = () => {
        if(reserveForm.checkin && reserveForm.checkout) {
            reserveForm.get(`/payment/${props.listing.id}`)
        }
        else {
            reserveFormAlert.value = true
        }
    }

    function incrementGuests(guest) {
        reserveForm.guests++
        switch(guest) {
            case 'adults':
            guests.adults++
            break
            case 'children':
            guests.children++
            break
            case 'infants':
            guests.infants++
            break
            case 'pets':
            guests.pets++
            break
        }
    }

    function decrementGuests(guest) {
        reserveForm.guests.value--
        switch(guest) {
            case 'adults':
            guests.adults--
            break
            case 'children':
            guests.children--
            break
            case 'infants':
            guests.infants--
            break
            case 'pets':
            guests.pets--
            break
        }
    }

</script>


<template>
    <Head :title="`${listing.title}`" />
    
    <v-container>
        <h1>{{ listing.title }}</h1>
        
        <v-row>
            <!-- ratings and location  -->
            <v-col cols="2"> 
                <v-icon color="orange-lighten-2">mdi-star</v-icon> {{ averageRating }} - ({{ ratings.length }} reviews) 
            </v-col>
            <v-col cols="8"> 
                <v-icon color="red">mdi-map-marker</v-icon> {{ listing.location }}
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
            <MazGallery :images="listingImages" :height="400" class="mt-1" />
        <v-divider class="mt-2" />
        <v-row>
            <v-col cols="8">
                <!-- Guest house details -->
                    <v-list >
                        <v-list-item>
                            <template v-slot:append>
                                <v-avatar size="90" id="avatar">
                                    <v-img :src="`../images/profile/${owner.profile_pic}`"></v-img>
                                </v-avatar>
                            </template>
                            <p class="text-h5">Guest house owned by {{ owner.firstname + ' ' + owner.lastname }}</p>
                                <v-chip color="white" v-if="listing.guests > 0">
                                    <p class="text-black">
                                        <v-icon>mdi-account-multiple</v-icon>
                                         {{ listing.guests }} Guests
                                        </p>
                                </v-chip>

                                <v-chip color="white" v-if="listing.rooms > 0">
                                    <p class="text-black">
                                        <v-icon>mdi-door-open</v-icon>
                                        {{ listing.rooms }} Rooms
                                    </p>
                                </v-chip>
                                <v-chip color="white" v-if="listing.beds > 0">
                                    <p class="text-black">
                                        <v-icon>mdi-bed</v-icon>
                                        {{ listing.beds }} Beds
                                    </p>
                                </v-chip>
                                <v-chip color="white" v-if="listing.bathrooms > 0">
                                    <p class="text-black">
                                        <v-icon>mdi-shower</v-icon>
                                        {{ listing.bathrooms }} Bathrooms
                                    </p>
                                </v-chip>
                            <!-- <p class="text-grey-darken-1"> {{ listing.guests }} guests - {{ listing.rooms }} room - {{ listing.beds }} bedroom - {{ listing.bathrooms }} bathroom </p> -->
                        </v-list-item>
                        <v-divider class="my-2" />
                        <v-list-item prepend-icon="mdi-information-variant">
                            {{ listing.description }} 
                            <br>
                        </v-list-item>
                        <v-list-item prepend-icon="mdi-map-marker">
                            {{ listing.location }}
                        </v-list-item>
                    </v-list>

                <!-- Place offers -->
                <v-container >
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
                                <span class="text-h6">₱{{ parseInt(listing.price).toLocaleString() }}</span> daily
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
                                        <v-alert variant="outlined" type="error" class="mt-5" prominent v-model="reserveFormAlert">
                                            <p class="font-weight-bold">Let's try that again</p>
                                            <p>Please input your check in and check out dates.</p>
                                        </v-alert>
                                        <v-menu activator="#menu-activator" :close-on-content-click="false">
                                            <v-list>
                                                <v-list-item title="Adults" subtitle="Age 13+">
                                                    <template v-slot:append>
                                                        <v-btn icon="mdi-plus" flat size="small" @click="incrementGuests('adults')" ></v-btn>
                                                        <span class="mx-1">{{ guests.adults }}</span> 
                                                        <v-btn icon="mdi-minus" flat size="small" @click="decrementGuests('adults')"> </v-btn>
                                                    </template>
                                                </v-list-item>
                                                <v-list-item title="Children" subtitle="Age 2 - 12">
                                                    <template v-slot:append>
                                                        <v-btn icon="mdi-plus" flat size="small" @click="incrementGuests('children')" ></v-btn>
                                                        <span class="mx-1">{{guests.children}}</span> 
                                                        <v-btn icon="mdi-minus" flat size="small" @click="decrementGuests('children')"> </v-btn>
                                                    </template>
                                                    
                                                </v-list-item>
                                                <v-list-item title="Infants" subtitle="Age under 2">
                                                    <template v-slot:append>
                                                        <v-btn icon="mdi-plus" flat size="small" @click="incrementGuests('infants')" ></v-btn>
                                                        <span class="mx-1">{{guests.infants}}</span> 
                                                        <v-btn icon="mdi-minus" flat size="small" @click="decrementGuests('infants')"> </v-btn>
                                                    </template>
                                                </v-list-item>
                                                <v-list-item title="Pets" subtitle="bruh">
                                                    <template v-slot:append>
                                                        <v-btn icon="mdi-plus" flat size="small" @click="incrementGuests('pets')" ></v-btn>
                                                        <span class="mx-1">{{ guests.pets }}</span> 
                                                        <v-btn icon="mdi-minus" flat size="small" @click="decrementGuests('pets')"> </v-btn>
                                                    </template>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </template>
                                    <v-card width="360">
                                        <v-date-picker color="blue" :landscape="true" :disabled="true" width="500" show-adjacent-months multiple v-model="reservationDate"></v-date-picker>
                                    </v-card>
                                </v-menu>
                                <!-- <v-select variant="outlined" class="mt-3"></v-select> -->
                            </v-col>
                        </v-row>
                    </v-card-item>
                        <v-list v-if="reservationDate">
                            <v-list-item>
                                {{ `₱${parseInt(listing.price).toLocaleString()} x ${reserveForm.days} days` }}
                                <template v-slot:append>
                                    {{ `₱${(listing.price * reserveForm.days).toLocaleString()}`  }}
                                </template>
                            </v-list-item>
                        <v-list-item v-if="reserveForm.days >= 30">
                            Monthly stay discount
                            <template v-slot:append>
                                <!-- DISPLAYS THE TOTAL - DISCOUNT PRICE -->
                                {{ `₱${((listing.price * reserveForm.days) * (listing.monthly_discount / 100)).toLocaleString()}`}}
                            </template>
                        </v-list-item>
                        <v-divider/>
                        <v-list-item class="font-weight-bold">
                            <p>Total</p>
                            <template v-slot:append v-if="reserveForm.days >= 30">
                                {{ `₱${((listing.price * reserveForm.days) - (listing.price * reserveForm.days) * (listing.monthly_discount / 100)).toLocaleString()}`  }}
                            </template>
                            <template v-slot:append v-else>
                                {{ `₱${((listing.price * reserveForm.days)).toLocaleString()}`  }}
                            </template>
                        </v-list-item>
                        </v-list>
                    <v-card-item>
                        <!-- <Link  :href=" reserveForm.date ? `/payment/${listing.id}?guests=${reserveForm.guests}&checkin=${reserveForm.date[0]}&checkout=${reserveForm.date[1]}` : ''"> -->
                            <v-btn color="green" @click="submitReservation" :disabled="reserveForm.processing" :loading="reserveForm.processing" class="text-none mb-4" width="100%" size="large">Reserve</v-btn>
                        <!-- </Link> -->
                    </v-card-item>
                    </form>
                </v-card>
            </v-col>
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
            <Map :latitude="listing.latitude" :longitude="listing.longitude" />
        </v-container>
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
        <RatingDialog :showReviewModal="showReviewModal" :auth="auth" :star="rating" :listing="listing" @closeReviewModal="showReviewModal = false" />
    </v-container>
</template>

<style scoped>


    #date {
        border: 1px solid black; 
        border-radius: 5px; 
    }
    .v-card.on-hover {
        opacity: 0.8;
    }

    #reserveBtn {
        position: sticky;
        top: 130px;
    }

</style>