<script setup>

    import {ref, onMounted, defineEmits} from 'vue'
    import L from 'leaflet'
    import 'leaflet/dist/leaflet.css'

    const emit = defineEmits(['setPos'])
    const mapContainer = ref(null)
    let map
    let marker
    onMounted(async() => {
        generateMap()
    })

    function generateMap() {
        map = L.map(mapContainer.value).setView([10.252763, 123.949394], 13)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)
        map.on('click', onMapClick)
    }

    function onMapClick(pos) {
        if(marker) {
            console.log('MARKER EXISTS REMOVE IT BITCH ASS HO')
            marker.remove()
        }
        marker = L.marker([pos.latlng.lat, pos.latlng.lng], {icon: markerIcon}).addTo(map)
        emit('setPos', pos)
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
        height: 500px;
        width: 80vw;
    }

</style>