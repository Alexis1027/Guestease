<script setup>
    import FullCalendar from '@fullcalendar/vue3'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import interactionPlugin from '@fullcalendar/interaction'
    import OwnerLayout from '../../Layouts/OwnerLayout.vue'
    import {ref, watch} from 'vue'
    import {router} from '@inertiajs/vue3'

    defineOptions({
        layout: OwnerLayout
    })

    const props = defineProps(['listing', 'listings', 'reservations'])
    const reservationDates = []
    const selectedListing = ref(props.listing)
    watch(selectedListing, () => {
        router.get(`/owner/calendar/${selectedListing.value}`)
    })

    props.reservations.forEach(reservation => {
        reservationDates.push({
            title: `${reservation.user.firstname +' '+ reservation.user.lastname}'s' Reservation`,
            start: reservation.checkin,
            end: reservation.checkout
        })
    })

    const calendarOptions = {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        dateClick: () => {
            alert('a day has been clicked!');
        },
        events: reservationDates
    }

</script>

<template>
    <Head title="Calendar"></Head>
    <v-container>
        <div v-if="listings.length > 0">
            <v-select :items="listings" v-model="selectedListing" item-title="title" item-value="id" label="Select listing"></v-select>
            <FullCalendar :options="calendarOptions" />
        </div>
        <div v-else class="text-center"> 
            <p class="text-h6 mt-6">No listings found <Link href="/owner/create-listing" class="text-decoration-underline text-blue">create now!</Link></p>
            
        </div>
    </v-container>
  </template>

  <style scoped>
  

  </style>
  

  