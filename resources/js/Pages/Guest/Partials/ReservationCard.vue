<script setup>

    import {format} from 'date-fns'
    import {defineEmits} from 'vue'

    const props = defineProps(['reservation'])
    const images = JSON.parse(props.reservation.listing.images)
    const emit = defineEmits(['openCancelReservationDialog'])

    const statusColor = new Map([
        ['approved', 'green'],
        ['pending', 'orange'],
        ['cancelled', 'red'],
    ])

    const openCancelReservationDialog = (reservation) => {
        emit('openCancelReservationDialog', reservation)
    }

</script>

<template>
    <v-card class="mt-3 border" width="100%">
        <!-- title and the image -->
        <Link :href="`/room/${reservation.listing.id}`">
            <v-list-item :title="reservation.listing.title" :subtitle="reservation.listing.location">
                <template v-slot:append>
                    <v-img :src="`/images/uploads/${images[0]}`" height="130" cover width="150"></v-img>
                </template>
            </v-list-item>
        </Link>
        <v-divider/>
        <div class="bg-red-lighten-3 pa-5 text-center" v-if="reservation.listing.status == 'Deleted'">Listing was deleted.</div>
        <v-list-item prepend-icon="mdi-account-multiple-outline"> {{ reservation.guests }} guest</v-list-item>
        <!-- reservation checkin and checkout dates -->
        <v-list-item prepend-icon="mdi-calendar-blank"> 
            {{ format(new Date(reservation.checkin), 'PPP') }} 
            <v-icon>mdi-arrow-right-thin</v-icon>
            {{ format(new Date(reservation.checkout), 'PPP') }}
         </v-list-item>
        <v-divider/>
        <!-- reservation status  -->
        <v-list-item>
            <p>Reservation status</p>
            <template v-slot:append>
                <v-chip size="small" :color="statusColor.get(reservation.status)">{{reservation.status}}</v-chip>
            </template>
         </v-list-item>
         <v-list-item>
            <p>Payment process</p>
            <template v-slot:append>
                {{ reservation.payment_process }}
            </template>
         </v-list-item>
         <!-- price x days -->
         <v-list-item>
            ₱{{ parseInt(reservation.listing.price).toLocaleString() }} x {{ reservation.days }} days
            <template v-slot:append>
                ₱{{ (reservation.listing.price * ( reservation.days)).toLocaleString() }}
            </template>
         </v-list-item>
         <v-list-item v-if="reservation.discount > 0">
            Monthly stay discount
            <template v-slot:append>
                ₱{{  (( reservation.listing.price * reservation.days) * (reservation.discount / 100)).toLocaleString()  }}
            </template>
         </v-list-item>
         <!-- total cost -->
         <v-list-item class="font-weight-bold">
            <p >Total cost</p>
            <template v-slot:append v-if="reservation.days >= 30">
                {{ `₱${((reservation.listing.price * reservation.days) - (( reservation.listing.price * reservation.days) * (reservation.discount / 100))).toLocaleString()}` }}
            </template>
            <template v-slot:append v-else>
                ₱{{ (reservation.listing.price * (reservation.days)).toLocaleString() }}
            </template>

         </v-list-item>
        <v-divider/>
        <!-- cancel reservation and contact owner buttons -->
         <v-card-actions class="justify-end d-flex">
            <v-btn color="red" variant="tonal" v-if="reservation.status == 'pending' " class="text-none me-1" @click="openCancelReservationDialog(reservation.id)">Cancel reservation</v-btn>
            <Link :href="`/profile/${reservation.listing.owner_id}`">
                <v-btn variant="flat" class="text-none" color="blue">Contact owner</v-btn>
            </Link>
         </v-card-actions>
    </v-card>
</template>