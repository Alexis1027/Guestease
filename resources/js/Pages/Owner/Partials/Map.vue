<script setup>

    import {ref, onMounted, defineEmits, watch} from 'vue'
    import L from 'leaflet'
    import 'leaflet/dist/leaflet.css'

    const emit = defineEmits(['setPos'])
    const mapContainer = ref(null)
    let map
    let marker
    onMounted(async() => {
        generateMap()
    })

    const {latitude, longitude} = defineProps(['latitude', 'longitude'])

    function generateMap() {
        console.log(latitude)
        map = L.map(mapContainer.value).setView([latitude, longitude], 13)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)
        map.on('click', onMapClick)
    }

    function onMapClick(pos) {
        if(marker) {
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
    {{ latitude }}
    {{ longitude }}
    <div class="leaflet-container" ref="mapContainer"></div>
</template>

<style scoped>

    .leaflet-container {
        height: 500px;
        width: 80vw;
    }

</style>