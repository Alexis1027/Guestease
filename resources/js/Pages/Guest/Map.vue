<script setup>

    import {ref, onMounted, defineProps} from 'vue'
    import L from 'leaflet'
    import 'leaflet/dist/leaflet.css'
    import GuestLayout from '../../Layouts/GuestLayout.vue';
    import MapSidebar from './partials/MapSidebar.vue';
    defineOptions({ layout: GuestLayout })
    // const lat = ref('')
    // const lon = ref('')
    // const dataLoaded = ref(false)
    const prop = defineProps(['listings'])
    // const search = ref('')
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
            <v-col cols="6">
                <p>Explore Now!</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <p>Cordova Cebu</p>
                <Link href="/">
                    <v-btn>LEARN MORE!</v-btn>
                </Link>
            </v-col>
            <v-col cols="6">
         <div class="leaflet-container" ref="mapContainer"></div>
            </v-col>
        </v-row>
</template>

<style scoped>

    .leaflet-container {
        height: 100vh;
        width: 50vw;
        right: 0;
        position: absolute;
    }

</style>