<script setup>

    import {ref, onMounted, defineProps} from 'vue'
    import L from 'leaflet'
    import 'leaflet/dist/leaflet.css'
    import Layout from '../../shared/Layout.vue';
    import MapSidebar from './partials/MapSidebar.vue';
    defineOptions({ layout: Layout })
    // const lat = ref('')
    // const lon = ref('')
    // const dataLoaded = ref(false)
    const prop = defineProps(['guesthouses'])
    const search = ref('')
    const mapContainer = ref(null)
    const mapSnackbar = ref(false)
    const currentGuestHouse = ref(null)
    const guesthousesLocation = []

    prop.guesthouses.forEach((gh) => {
        guesthousesLocation.push({
            'guesthouse': gh
        })
    })

    onMounted(async() => {
        generateMap()
    })

    
    function generateMap() {
        const map = L.map(mapContainer.value).setView([10.252763, 123.949394], 13)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)

        guesthousesLocation.forEach(place => {
            const marker = L.marker([place.guesthouse.latitude, place.guesthouse.longitude], {icon: markerIcon}).addTo(map)
            marker.bindPopup(`<b> Hello from ${place.guesthouse.room_name}! </b> <br> I'm a popup!`)
            marker.on('click', () => {
                mapSnackbar.value = true
                currentGuestHouse.value = place.guesthouse
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
    <v-text-field variant="outlined" color="blue" label="Where do you want to go?" v-model="search">
        <template v-slot:append-inner>
            <v-scroll-x-transition>
                <v-btn v-show="search" icon="mdi-map-search-outline" variant="text"></v-btn>
            </v-scroll-x-transition>
        </template>
    </v-text-field>
    
    <MapSidebar :mapSnackbar="mapSnackbar" :guesthouse="currentGuestHouse" @closeMapSnackbar="mapSnackbar = false" ></MapSidebar>
    <div class="leaflet-container" ref="mapContainer"></div>
</template>

<style scoped>

    .leaflet-container {
        height: 75vh;
        width: 86vw;
    }

</style>