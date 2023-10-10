<script setup>

    import {ref, onMounted, defineProps} from 'vue'
    import L from 'leaflet'
    import 'leaflet/dist/leaflet.css'
    import Layout from '../../Layouts/GuestLayout.vue';
    import MapSidebar from './partials/MapSidebar.vue';
    defineOptions({ layout: Layout })
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
        const map = L.map(mapContainer.value).setView([10.252763, 123.949394], 13)
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
        iconUrl: '../images/icons/marker.png',
        iconSize:     [30, 30], // size of the icon
    });

</script>

<template>
    <Head title="Map" />
    <MapSidebar :mapSnackbar="mapSnackbar" :listing="currentlisting" @closeMapSnackbar="mapSnackbar = false" ></MapSidebar>
    <div class="leaflet-container" ref="mapContainer"></div>
</template>

<style scoped>

    .leaflet-container {
        height: 75vh;
        width: 86vw;
    }

</style>