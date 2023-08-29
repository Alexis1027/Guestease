<script setup>

    import Layout from '../shared/Layout.vue'
    import ReservationCard from '../components/ReservationCard.vue'
    defineOptions({layout: Layout})
    defineProps({reservations: Object})
</script>


<template>
        <Head title="Reservations" />
        <h1>Reservations</h1>
        <div v-for="reservation in reservations" :key="reservation.id">
            <ReservationCard :reservation="reservation" />
        </div>
</template>

