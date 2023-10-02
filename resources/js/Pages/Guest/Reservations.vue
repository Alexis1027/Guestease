<script setup>

    import Layout from '../../Layouts/GuestLayout.vue'
    import ReservationCard from './Partials/ReservationCard.vue'
    import {ref} from 'vue'
    import {processImages} from '@/utils/imageUtils.js'
    defineOptions({layout: Layout})
    defineProps({reservations: Object, auth: Object})
    const cancelReservationDialog = ref(false)
</script>


<template>
        <Head title="Reservations" />
        <p class="text-h4">Welcome, {{ auth.user.firstname }}</p>
        <p class="text-h6 mb-6">Here, you can view a history of all your bookings.</p>
        <v-row>
            <v-col cols="6" v-for="reservation in reservations" :key="reservation.id">
            <ReservationCard :reservation="reservation" @openCancelReservationDialog="cancelReservationDialog = true" />
            </v-col>
        </v-row>
        <p class="ms-6 mt-6" v-if="reservations.length == 0">No reservations found.</p>
        <v-dialog
      v-model="cancelReservationDialog"
      width="auto"
    >
      <v-card>
        <v-card-text>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </v-card-text>
        <v-card-actions>
          <v-btn color="primary" block @click="cancelReservationDialog = false">Close Dialog</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
</template>

