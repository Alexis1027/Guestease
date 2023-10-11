<script setup>

    import {defineEmits, onMounted, ref} from 'vue'
    import MazCarousel from 'maz-ui/components/MazCarousel'
    import MazCard from 'maz-ui/components/MazCard'
    import {format} from 'date-fns'
    import {router} from '@inertiajs/vue3'
    import L from 'leaflet'
    import 'leaflet/dist/leaflet.css'

    const emit = defineEmits('closeReviewListingModal', 'approved')
    const prop = defineProps(['show', 'listing'])
    const mapContainer = ref(null)

    onMounted(async() => {
        generateMap()
    })

    function generateMap() {
        const map = L.map(mapContainer.value).setView([prop.listing.latitude, prop.listing.longitude], 15)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)
        L.marker([prop.listing.latitude, prop.listing.longitude], {icon: markerIcon}).addTo(map)
    }

    var markerIcon = L.icon({
        iconUrl: '../images/icons/marker2.png',
        iconSize:     [50, 50], // size of the icon
    })

    const approveListing = () => {
        console.log(prop.listing.id)
        router.put(`/admin/approve-listing`, {listing_id: prop.listing.id})
        emit('approved')
        emit('closeReviewListingModal')
    }

</script>

<template>
    
    <v-dialog v-model="prop.show" width="auto" scrollable fullscreen transition="dialog-bottom-transition">
        <v-card>
            <v-card-actions>
                <p class="text-h4">{{ listing.title }}</p>
                <v-spacer/>
                <v-btn color="error" icon="mdi-close" @click="emit('closeReviewListingModal')"></v-btn>
            </v-card-actions>
            <v-card-item>
                <MazCarousel>
                    <template #title>
                        <p class="text-h6">Photos</p>
                    </template>
                    <MazCard galleryWidth="100%" :elevation="0" v-for="(item, i) in JSON.parse(listing.images)" zoom :key="i" :images="[`../images/${JSON.parse(listing.images)[i]}`]" style="min-width: 250px;">
                    </MazCard>
                </MazCarousel>
            </v-card-item>
            <v-card-item>
                <v-row>
                    <v-col cols="6">
                        <v-list>
                            <p class="text-h6">Listing details</p>
                            <v-list-item subtitle="Description" prepend-icon="mdi-information-outline">
                                {{ listing.description }}
                            </v-list-item>
                            <v-list-item subtitle="Location" prepend-icon="mdi-map-marker">
                                {{ listing.location }}
                            </v-list-item>
                            <v-list-item subtitle="Price" prepend-icon="mdi-cash-multiple">
                                ₱{{ parseInt(listing.price).toLocaleString() }}
                            </v-list-item>
                            <v-list-item subtitle="Created at" prepend-icon="mdi-map-marker">
                                {{ format(new Date(listing.created_at), 'MMM dd, y') }}
                            </v-list-item>
                        </v-list>
                    </v-col>
                    <v-divider vertical />
                    <v-col cols="6">
                        <v-row class="mt-1">
                            <v-col cols="12">
                                <p class="text-h6">Amenities</p> 
                                <v-chip class="ms-2 mt-2" :prepend-icon="amenity.icon" v-for="amenity in JSON.parse(listing.amenities)" :key="amenity">
                                    {{ amenity.title }}
                                </v-chip>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="6">
                                <p class="text-h6">Rooms and spaces</p> 
                                <v-list-item prepend-icon="mdi-account-multiple">
                                    <template v-slot:append>
                                        {{ listing.guests }}  
                                    </template>
                                    Guests
                                </v-list-item>
                                <v-list-item prepend-icon="mdi-bed">
                                    <template v-slot:append>
                                        {{ listing.beds }}  
                                    </template>
                                    Beds
                                </v-list-item>
                                <v-list-item prepend-icon="mdi-shower">
                                    <template v-slot:append>
                                        {{ listing.bathrooms }}  
                                    </template>
                                    Bathrooms
                                </v-list-item>
                                <v-list-item prepend-icon="mdi-door-open">
                                    <template v-slot:append>
                                        {{ listing.rooms }}  
                                    </template>
                                    Rooms
                                </v-list-item>
                            </v-col>
                        </v-row>
                    </v-col>
                    
                </v-row>
                <v-row>
                    <v-col cols="6">
                        <p class="text-h6">Map</p> 
                        <div class="leaflet-container" ref="mapContainer"></div>
                    </v-col>
                    <v-col cols="6" v-if="listing.bldg_permit">
                        <p class="text-h6">Listing building permit image</p> 
                        <v-img :src="`../images/${listing.bldg_permit}`" cover height="350"></v-img>
                    </v-col>
                </v-row>
            </v-card-item>
            <v-card-actions class="d-flex justify-end my-3">
                <v-btn color="error" variant="tonal" @click="emit('closeReviewListingModal')">Cancel</v-btn>
                <v-btn color="green" variant="tonal" @click="approveListing">Approve</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

</template>

<style scoped>
    
    .leaflet-container {
        height: 350px;
        width: 100%;

    }

</style>