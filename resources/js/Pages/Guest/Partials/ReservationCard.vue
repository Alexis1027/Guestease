<script setup>

    import {format} from 'date-fns'
    import {defineEmits} from 'vue'
    defineProps({reservation: Object})
    const emit = defineEmits(['openCancelReservationDialog'])

    const openCancelReservationDialog = () => {
        emit('openCancelReservationDialog')
    }

</script>

<template>
    <v-card class="mt-3 border" width="100%">
        <Link :href="`/room/${reservation.guesthouse.id}`">
            <v-list-item :title="reservation.guesthouse.title" :subtitle="`Guest house in ${reservation.guesthouse.location}`">
                <template v-slot:append>
                    <v-img src="../images/room.png" height="130" cover width="150"></v-img>
                </template>
            </v-list-item>
        </Link>
        <v-divider/>
        <v-list-item prepend-icon="mdi-account-multiple-outline"> {{ reservation.guests }} guest</v-list-item>
        <v-list-item prepend-icon="mdi-calendar-blank"> 
            {{ format(new Date(reservation.checkin), 'MMMM dd, yyyy') }} 
            <v-icon>mdi-arrow-right-thin</v-icon>
            {{ format(new Date(reservation.checkout), 'MMMM dd, yyyy') }}
         </v-list-item>
        <v-divider/>
        <v-list-item>
            <p class="font-weight-bold">Reservation status</p>
            <template v-slot:append>
                <p class="text-orange">{{reservation.status}}</p>
            </template>
         </v-list-item>
         <v-list-item>
            ₱{{ parseInt(reservation.guesthouse.price).toLocaleString() }} x {{ reservation.days }} days
            <template v-slot:append>
                ₱{{ (reservation.guesthouse.price * ( reservation.days)).toLocaleString() }}
            </template>
         </v-list-item>
         <v-list-item v-if="reservation.days >= 30">
            Monthly stay discount
            <template v-slot:append>
                ₱{{  (( reservation.guesthouse.price * reservation.days) * (reservation.guesthouse.monthly_discount / 100)).toLocaleString()  }}
            </template>
         </v-list-item>
       
         <v-list-item>
            <p class="font-weight-bold">Total cost</p>
            <template v-slot:append v-if="reservation.days >= 30">
                {{ `₱${((reservation.guesthouse.price * reservation.days) - ( reservation.guesthouse.price * reservation.days) * (reservation.guesthouse.monthly_discount / 100)).toLocaleString()}` }}
            </template>
            <template v-slot:append v-else>
                ₱{{ (reservation.guesthouse.price * (reservation.days)).toLocaleString() }}
            </template>

         </v-list-item>
        <v-divider/>
         <v-card-actions class="justify-end d-flex">
            <v-btn color="red" @click="openCancelReservationDialog">Cancel Reservation</v-btn>
            <Link :href="`/profile/${reservation.guesthouse.owner_id}`">
                <v-btn variant="flat" color="blue">Contact owner</v-btn>
            </Link>
         </v-card-actions>
    </v-card>
</template>