<script setup>

    import {ref, onMounted, defineProps} from 'vue'
    import L from 'leaflet'
    import 'leaflet/dist/leaflet.css'
    const props = defineProps(['latitude', 'longitude'])
    const mapContainer = ref(null)

    const address = [
        {
            'id': 1,
            'houseName': 'Guest House 1',
            'coord': [props.latitude, props.longitude]
        },
        // {
        //     'id': 2,
        //     'houseName': 'Guest House 2',
        //     'coord': [10.257239, 123.959788]
        // },
        
    ]

    onMounted(async() => {

        generateMap()

    })

    function generateMap() {
        const map = L.map(mapContainer.value).setView([props.latitude, props.longitude], 13)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)
        address.forEach(place => {
            const marker = L.marker([place.coord[0], place.coord[1]], {icon: markerIcon}).addTo(map)
            marker.bindPopup(`<b> This is where you'll be! </b>`)
            marker.on('click', () => {
                mapSnackbar.value = true
                currentGuestHouse.value = place
            })
        });
    }

    var markerIcon = L.icon({
        iconUrl: '../images/icons/marker2.png',
        iconSize:     [50, 50], // size of the icon
    });

</script>

<template>
    <div class="leaflet-container" ref="mapContainer"></div>
</template>

<style scoped>

    .leaflet-container {
        height: 75vh;
        width: 82vw;
    }

</style>