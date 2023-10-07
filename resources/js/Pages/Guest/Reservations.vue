<script setup>

    import Layout from '../../Layouts/GuestLayout.vue'
    import ReservationCard from './Partials/ReservationCard.vue'
    import {ref} from 'vue'
    defineOptions({layout: Layout})
    defineProps({reservations: Object, auth: Object})
    const cancelReservationDialog = ref(false)
    const reservationToCancel = ref(null)
    const cancelReservation = (reservation) => {
        console.log(reservation)
        cancelReservationDialog.value = true
        reservationToCancel.value = reservation
    }


</script>


<template>
        <Head title="Reservations" />
        <p class="text-h4">Welcome, {{ auth.user.firstname }}</p>
        {{ reservationToCancel }}
        <p class="text-h6 mb-6">Here, you can view a history of all your bookings.</p>
        <v-row>
            <v-col cols="6" v-for="reservation in reservations" :key="reservation.id">
                <ReservationCard :reservation="reservation" @openCancelReservationDialog="cancelReservation" />
            </v-col>
        </v-row>
        <p class="ms-6 mt-6" v-if="reservations.length == 0">No reservations found.</p>
        <v-dialog
      v-model="cancelReservationDialog"
      width="auto"
    >
      <v-card>
        <v-card-title>
            Cancel Reservation?
        </v-card-title>
        <v-card-text>
            Are you sure you want to cancel this reservation?
        </v-card-text>
        <v-card-actions class="justify-end">
          <v-btn  @click="cancelReservationDialog = false">No</v-btn>
            <Link :href="`/reservations/cancel/${reservationToCancel}`" method="PUT" :data="{reservation_id: reservationToCancel}">
                <v-btn color="error" @click="cancelReservationDialog = false">Yes</v-btn>
            </Link>
        </v-card-actions>
      </v-card>
    </v-dialog>
</template>

