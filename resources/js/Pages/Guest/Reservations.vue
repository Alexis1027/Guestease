<script setup>

    defineOptions({layout: GuestLayout})
    defineProps({reservations: Object, auth: Object})
    import GuestLayout from '../../Layouts/GuestLayout.vue'
    import ReservationCard from './Partials/ReservationCard.vue'
    import {ref} from 'vue'

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
    <v-container>
        <v-row justify="end">
            <v-col>
                <p class="text-h4">Reservations</p>
            </v-col>
            <v-col cols="3">
                <!-- <Link href="/reservation-history">
                    <v-btn variant="tonal" color="blue">View reservation history</v-btn>
                </Link> -->
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="6" v-for="reservation in reservations" :key="reservation.id">
                <ReservationCard :reservation="reservation" @openCancelReservationDialog="cancelReservation(reservation)" />
            </v-col>
        </v-row>
        <p class="ms-6 mt-6" v-if="reservations.length == 0">No reservations found.</p>
        
    </v-container>
    <v-dialog v-model="cancelReservationDialog" width="auto">
        <v-card>
            <v-card-title>
                Cancel Reservation?
            </v-card-title>
            <v-card-text>
                Are you sure you want to cancel this reservation?
            </v-card-text>
            <v-card-actions class="justify-end">
                <v-btn @click="cancelReservationDialog = false">No</v-btn>
                <Link :href="`/reservations/cancel/${reservationToCancel.id}`" method="PUT" :data="{listing_id: reservationToCancel.listing_id}">
                    <v-btn color="error" @click="cancelReservationDialog = false">Yes</v-btn>
                </Link>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

