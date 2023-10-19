<script setup>
    import FullCalendar from '@fullcalendar/vue3'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import interactionPlugin from '@fullcalendar/interaction'
    import OwnerLayout from '../../Layouts/OwnerLayout.vue'

    defineOptions({
        layout: OwnerLayout
    })

    const calendarOptions = {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        dateClick: () => {
            alert('a day has been clicked!');
        },
        events: [
            { title: `John doe's reservation`, start: '2023-10-20', end: '2023-10-25' },
            { title: `Mr. Perrel Brown's reservation`, start: '2023-10-10', end: '2023-10-19' },
            { title: `John Doe's reservation`, start: '2023-10-01' },
            { title: `Jane Doe's reservation`, start: '2023-10-19' }
        ],
    }
</script>

<template>
    <Head title="Calendar"></Head>
    <v-select :items="['listing 1', 'listing 2', 'listing 3']" label="Select listing"></v-select>
    <FullCalendar :options="calendarOptions" />
  </template>
  

  