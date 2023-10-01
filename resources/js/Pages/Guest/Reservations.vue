<script setup>

    import Layout from '../../Layouts/GuestLayout.vue'
    import ReservationCard from '../../components/ReservationCard.vue'
    defineOptions({layout: Layout})
    defineProps({reservations: Object, auth: Object})
</script>


<template>
        <Head title="Reservations" />
        <p class="text-h4">Welcome, {{ auth.user.firstname }}</p>
        <p class="text-h6">Here, you can view a history of all your bookings with our guest house reservation system.</p>
        <div v-for="reservation in reservations" :key="reservation.id">
            <ReservationCard :reservation="reservation" />
        </div>
        <p class="ms-6" v-if="reservations.length == 0">No reservations found.</p>
</template>

