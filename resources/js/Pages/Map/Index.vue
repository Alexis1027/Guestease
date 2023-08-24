<script setup>

    import {ref, onMounted, watch} from 'vue'
    import L from 'leaflet'
    import 'leaflet/dist/leaflet.css'
    import Layout from '../../shared/Layout.vue';
    import MapSidebar from '../../components/MapSidebar.vue';
    defineOptions({ layout: Layout })
    // const lat = ref('')
    // const lon = ref('')
    // const dataLoaded = ref(false)
    const search = ref('')
    const mapContainer = ref(null)
    const mapSnackbar = ref(false)
    const currentGuestHouse = ref(null)

    const address = [
        {
            'id': 1,
            'houseName': 'Guest House 1',
            'coord': [10.250984, 123.939499]
        },
        {
            'id': 2,
            'houseName': 'Guest House 2',
            'coord': [10.257239, 123.959788]
        },
        {
            'id': 3,
            'houseName': 'Guest House 3',
            'coord': [10.259351, 123.942876]
        },
        {
            'id': 4,
            'houseName': 'Guest House 4',
            'coord': [10.266107, 123.949229]
        },
        {
            'id': 5,
            'houseName': 'Guest House 5',
            'coord': [10.263067, 123.962449]
        }
        
    ]

    onMounted(async() => {

        // navigator.geolocation.getCurrentPosition(pos => {
        //     console.log(pos)
        //     lat.value = pos.coords.latitude
        //     lon.value = pos.coords.longitude
        //     dataLoaded.value = true
        // })

        // watch(dataLoaded, () => {
        //     generateMap()
        // })

        generateMap()

    })

    function generateMap() {
        const map = L.map(mapContainer.value).setView([10.252763, 123.949394], 13)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)
        // const marker = L.marker([10.250984, 123.939499], {icon: greenIcon}).addTo(map)
        // marker.bindPopup("<b> Hello Giatay! </b> <br> I'm a popup!")
        // map.on('click', onMapClick)

        address.forEach(place => {
            const marker = L.marker([place.coord[0], place.coord[1]], {icon: markerIcon}).addTo(map)
            marker.bindPopup(`<b> Hello from ${place.houseName}! </b> <br> I'm a popup!`)
            marker.on('click', () => {
                mapSnackbar.value = true
                currentGuestHouse.value = place
            })
        });

    }

    var markerIcon = L.icon({
        iconUrl: 'https://img.icons8.com/isometric/50/experimental-home-isometric.png',
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