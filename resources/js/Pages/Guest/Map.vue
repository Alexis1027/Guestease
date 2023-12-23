<script setup>

    defineOptions({ layout: GuestLayout })
    const prop = defineProps(['listings'])
    import {ref, onMounted, defineProps} from 'vue'
    import L from 'leaflet'
    import 'leaflet/dist/leaflet.css'
    import GuestLayout from '../../Layouts/GuestLayout.vue';
    import MapSidebar from './partials/MapSidebar.vue';
 
    const mapContainer = ref(null)
    const mapSnackbar = ref(false)
    const currentlisting = ref(null)
    const listingsLocation = []

    prop.listings.forEach((ls) => {
        listingsLocation.push({
            'listing': ls
        })
    })

    onMounted(async() => {
        generateMap()
    })

    
    function generateMap() {
        const map = L.map(mapContainer.value).setView([10.252763, 123.949394], 15)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)

        listingsLocation.forEach(place => {
            const marker = L.marker([place.listing.latitude, place.listing.longitude], {icon: markerIcon}).addTo(map)
            marker.bindPopup(`<b> Hello from ${place.listing.location}! </b> <br> I'm a popup!`)
            marker.on('click', () => {
                mapSnackbar.value = true
                currentlisting.value = place.listing
            })
        });
    }

    var markerIcon = L.icon({
        iconUrl: '/images/icons/marker.png',
        iconSize:     [30, 30], // size of the icon
    });

</script>

<template>
    <Head title="Map" />
    <MapSidebar :mapSnackbar="mapSnackbar" :listing="currentlisting" @closeMapSnackbar="mapSnackbar = false" ></MapSidebar>
        <v-row>
            <v-col cols="12" sm="12" md="12" lg="12" xl="4" xxl="4" id="info" class="bg-white">
                <v-container class="text-center mt-6">
                    <p class="text-h4">Explore Now!</p>
                    <p>
                        Explore the beauty of Cordova, Cebu. This vibrant destination offers a unique blend of culture and natural wonders, making it an ideal place to create lasting memories.
                        Cordova Cebu is a charming town located in the Philippines, known for its warm hospitality and picturesque landscapes. Whether you're interested in cultural experiences, delicious cuisine, or simply enjoying the scenic views, Cordova has something for everyone.
                    </p>
                    <v-divider class="my-3"/>
                    <p class="text-h4">Cordova Cebu</p>
                    <Link href="/">
                        <v-btn class="mt-6 text-none" color="blue">Learn more</v-btn>
                    </Link>
                </v-container>
            </v-col>
            <v-col cols="12" sm="12" md="12" lg="12" xl="8" xxl="8">
                <div class="leaflet-container" ref="mapContainer"></div>
            </v-col>
            
        </v-row>
</template>

<style scoped>

    .leaflet-container {
        height: 100vh;
        width: 100%;
    }

</style>