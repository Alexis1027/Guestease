<script setup>

    import {ref, onMounted, defineEmits} from 'vue'
    import L from 'leaflet'
    import 'leaflet/dist/leaflet.css'

    const emit = defineEmits(['setPos'])
    const mapContainer = ref(null)

    onMounted(async() => {
        console.log("GO ")
        generateMap()
    })


    function generateMap() {
        const map = L.map(mapContainer.value).setView([10.252763, 123.949394], 15)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)
    }

 

</script>

<template>
    <div class="leaflet-container" ref="mapContainer"></div>
</template>

<style scoped>

    .leaflet-container {
        height: 500px;
        width: 1000px;
    }

</style>