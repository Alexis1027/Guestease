<script setup>
    import FullCalendar from '@fullcalendar/vue3'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import interactionPlugin from '@fullcalendar/interaction'
    import OwnerLayout from '../../Layouts/OwnerLayout.vue'

    defineOptions({
        layout: OwnerLayout
    })

    const props = defineProps(['listing', 'reservations'])

    const reservationDates = []

    props.reservations.forEach(reservation => {
        reservationDates.push({
            title: 'Reservation',
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
    {{ reservationDates }}
    <v-select :items="['listing 1', 'listing 2', 'listing 3']" label="Select listing"></v-select>
    <FullCalendar :options="calendarOptions" />
  </template>
  

  