<script setup>

    import {ref, onMounted, defineProps} from 'vue'
    import L from 'leaflet'
    import 'leaflet/dist/leaflet.css'
    const props = defineProps(['latitude', 'longitude'])
    const mapContainer = ref(null)

    onMounted(async() => {
        generateMap()
    })

    function generateMap() {
        const map = L.map(mapContainer.value).setView([props.latitude, props.longitude], 13)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)
        const marker = L.marker([props.latitude, props.longitude], {icon: markerIcon}).addTo(map)
        marker.bindPopup(`<b> This is where you'll be! </b>`)
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