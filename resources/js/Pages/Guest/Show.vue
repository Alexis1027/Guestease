<script setup>

    import GuestLayout from '../../Layouts/GuestLayout.vue'
    import {defineProps, ref} from 'vue'
    import { useForm } from '@inertiajs/vue3'
    import RatingCard from '../Guest/Partials/RatingCard.vue'
    import RatingDialog from './Partials/RatingDialog.vue'
    import Map from '../Guest/Partials/ShowMap.vue'
    import {format} from 'date-fns'
    import MazGallery from 'maz-ui/components/MazGallery'
    import DatePicker from './Partials/DatePicker.vue'
    
    defineOptions({layout: GuestLayout})

    const props = defineProps(['listing', 'ratings', 'averageRating', 'is_reserved', 'wishlist', 'auth', 'rated', 'owner', 'reservedDates'])
    const rating = ref(0)
    const showReviewModal = ref(false)
    const images = JSON.parse(props.listing.images)
    const listingImages = images.map(img => '/images/uploads/' + img)
    const amenities = JSON.parse(props.listing.amenities)
    const reserveFormAlert = ref(false)

    // save and unsave wishlist form
    const saveWishlistForm = useForm({
        user_id: props.auth ? props.auth.user.id : '',
        listing_id: props.auth ? props.listing.id : '',
    })


     const submitSaveWishlistForm = () => {
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

    const submitReservation = () => {
        if(reserveForm.checkin && reserveForm.checkout) {
            reserveForm.get(`/confirm-reservation/${props.listing.id}`)
        }
        else {
            reserveFormAlert.value = true
        }
    }

    const updateDate = (date) => {
        // if(props.listing.type == 'Guest house') {
        //     console.log(date.value.start)
        //     reserveForm.checkin = date.value.start
        //     const startDate = new Date(date.value.start)
        //     reserveForm.checkout = startDate.setMonth(startDate.getMonth() + 1)
        //     reserveForm.days = Math.abs((new Date(reserveForm.checkin) - new Date(reserveForm.checkout)) / (1000 * 3600 * 24)) 
        // }
        // else {
            reserveForm.checkin = date.value.start
            reserveForm.checkout = date.value.end
            reserveForm.days = Math.abs((new Date(reserveForm.checkin) - new Date(reserveForm.checkout)) / (1000 * 3600 * 24)) 
        // }
        
    }

</script>


<template>
    <Head :title="`${listing.title}`" />
    
    <v-container>
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
                <v-form @submit.prevent="submitSaveWishlistForm">
                    <v-btn 
                        class="text-none" 
                        :loading="saveWishlistForm.processing" 
                        type="submit"
                        rounded 
                        :color="wishlist ? 'red' : ''"
                        variant="text"
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
            <MazGallery :images="listingImages" :height="450" class="mt-1" />
        <v-row>
            <v-col cols="8">
                <!-- Guest house details -->
                <v-list-item>
                    <!-- <template v-slot:append>
                        <Link :href="`/profile/${owner.id}`">
                            <v-avatar size="90" id="avatar">
                                <v-img :src="`/images/profile/${owner.profile_pic}`"></v-img>
                            </v-avatar>
                        </Link>
                    </template> -->
                    <p class="text-h5 text-capitalize">{{ listing.title }}</p>
                        <v-chip v-if="listing.guests > 0">
                            <p>
                                <v-icon>mdi-account-multiple</v-icon>
                                    {{ listing.guests }} Guests
                            </p>
                        </v-chip>

                        <v-chip v-if="listing.rooms > 0">
                            <p>
                                <v-icon>mdi-door-open</v-icon>
                                {{ listing.rooms }} Rooms
                            </p>
                        </v-chip>
                        <v-chip v-if="listing.beds > 0">
                            <p>
                                <v-icon>mdi-bed</v-icon>
                                {{ listing.beds }} Beds
                            </p>
                        </v-chip>
                        <v-chip v-if="listing.bathrooms > 0">
                            <p>
                                <v-icon>mdi-shower</v-icon>
                                {{ listing.bathrooms }} Bathrooms
                            </p>
                        </v-chip>
                </v-list-item>
                    
                    <v-container>
                        <p class="text-h5 font-weight-medium">About this place </p>
                        <v-divider class="my-2" />
                        {{ listing.description }}
                        <br>
                        Located in - {{ listing.location }}
                    </v-container>
                    <v-divider/>
                    <v-container>
                        <v-list-item>
                            <template v-slot:append>
                                <Link :href="`/profile/${owner.id}`">
                                    <v-avatar size="80" id="avatar">
                                        <v-img :src="`/images/profile/${owner.profile_pic}`"></v-img>
                                    </v-avatar>
                                </Link>
                            </template>
                        <p class="text-h5">{{listing.type}} owned by <span class="text-capitalize">{{ owner.firstname + ' ' + owner.lastname }}</span> </p>
                        </v-list-item>
                        <v-divider class="my-2"/>
                        <v-row>
                            <v-col cols="6">
                                <v-list-item prepend-icon="mdi-facebook-messenger" subtitle="Messenger">
                                    <p class="text-capitalize">{{ owner.firstname + ' ' + owner.lastname }}</p>
                                </v-list-item>
                            </v-col>
                            <v-col cols="6">
                                <v-list-item prepend-icon="mdi-email-open" subtitle="Email"> {{ owner.email }}
                                </v-list-item>
                            </v-col>
                            <v-col cols="6">
                                <v-list-item prepend-icon="mdi-phone" class="text-capitalize" subtitle="Contact number" > {{owner.phone_number}}
                                </v-list-item>
                            </v-col>
                            <v-col cols="6">
                                <v-list-item prepend-icon="mdi-calendar-range" subtitle="Joined at">
                                    {{ format(new Date(owner.created_at), 'MMMM dd, y') }}
                                </v-list-item>
                            </v-col>
                        </v-row>
                    </v-container>

                <!-- Place offers -->
                <v-container >
                    <p class="text-h5">Offered amenities</p>
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
                <v-container v-if="auth && is_reserved">
                    <p class="text-h5 font-weight-medium">Rate this place </p>
                    <p>Tell others what you think. </p>
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
                    <v-container id="reserveBtn" class="border">
                        <span class="text-h6">₱{{ parseInt(listing.price).toLocaleString() }}</span> {{ listing.type == "Guest house" ? "monthly" : "daily" }}
                        <DatePicker @updateDate="updateDate" :reservedDates="reservedDates" :listingType="listing.type" />
                        <v-alert variant="outlined" type="error" class="mt-5" prominent v-model="reserveFormAlert">
                            <p class="font-weight-bold">Let's try that again</p>
                            <p>Please input your check in and check out dates.</p>
                        </v-alert>
                        <v-list-item prepend-icon="mdi-account-multiple" title="Guests">
                            <template v-slot:append>
                                <v-btn icon="mdi-plus" size="small" variant="text" v-if="reserveForm.guests < listing.guests" @click="reserveForm.guests++"></v-btn>
                                {{ reserveForm.guests }}
                                <v-btn icon="mdi-minus" size="small" variant="text" v-if="reserveForm.guests >= 2" @click="reserveForm.guests--"></v-btn> 
                            </template>
                        </v-list-item>
                        <v-list v-if="reserveForm.checkin && reserveForm.checkout">
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
                        
                        <div v-if="auth">
                            <div v-if="is_reserved.length >= 1">
                                <v-btn 
                                    v-if=" is_reserved[is_reserved.length-1].status == 'cancelled'"
                                    @click="submitReservation" 
                                    :disabled="owner.id == auth.user.id" 
                                    :loading="reserveForm.processing" 
                                    class="mb-4" 
                                    width="100%" 
                                    size="large"
                                    color="green"
                                    >
                                    Reserve
                                </v-btn>
                                <v-btn block v-else disabled size="large"> Reserved </v-btn>
                            </div>
                            <div v-else>
                                <v-btn 
                                    color="green" 
                                    v-if="listing.status == 'Available' && is_reserved.length <= 0" 
                                    @click="submitReservation" 
                                    :disabled="reserveForm.processing" 
                                    :loading="reserveForm.processing" 
                                    class="mb-4" 
                                    width="100%" 
                                    size="large"
                                    >
                                    Reserve
                                </v-btn>
                                <v-btn block v-else disabled size="large"> Reserved </v-btn>
                            </div>
                        </div>
                        <div v-else>
                            <v-btn 
                                color="green" 
                                v-if="listing.status == 'Available'" 
                                @click="submitReservation" 
                                :disabled="reserveForm.processing" 
                                :loading="reserveForm.processing" 
                                class="mb-4"
                                width="100%"
                                size="large"
                                >
                                Reserve
                            </v-btn>
                            <v-btn block v-else disabled size="large"> Reserved </v-btn>
                        </div>
                        
                    </v-container>
            </v-col>
            <!-- Ratings and reviews section -->
            <v-container class="mb-5">
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
            <p class="text-h5 font-weight-medium mb-6">Where you'll be.</p>
            <Map class="ms-5" :latitude="listing.latitude" :longitude="listing.longitude" />
        <!-- HOUSE RULES -->
        <v-container>
            <p class="text-h5 font-weight-medium mb-6">House rules</p>
            <v-divider />
            <v-list-item prepend-icon="mdi-circle-medium" v-for="rule in JSON.parse(listing.rules)" :key="rule">
                {{ rule }}
            </v-list-item>
        </v-container>
        <v-divider class="my-5" />
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
        box-shadow: 10px 10px 5px lightblue;
    }

    .v-chip {
        margin: 6px;
    }

</style>