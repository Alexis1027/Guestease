<script setup>

    import {format} from 'date-fns'
    import {defineEmits} from 'vue'
    import {processImages} from '@/utils/imageUtils.js'

    const props = defineProps(['reservation'])
    const images = processImages(props.reservation.guesthouse.images)
    const emit = defineEmits(['openCancelReservationDialog'])

    const openCancelReservationDialog = () => {
        emit('openCancelReservationDialog')
    }

</script>

<template>
    <v-card class="mt-3 border" width="100%">
        <!-- title and the image -->
        <Link :href="`/room/${reservation.guesthouse.id}`">
            <v-list-item :title="reservation.guesthouse.title" :subtitle="`Guest house in ${reservation.guesthouse.location}`">
                <template v-slot:append>
                    <v-img :src="`../images/${images[0]}`" height="130" cover width="150"></v-img>
                </template>
            </v-list-item>
        </Link>
        <v-divider/>
        <v-list-item prepend-icon="mdi-account-multiple-outline"> {{ reservation.guests }} guest</v-list-item>
        <!-- reservation checkin and checkout dates -->
        <v-list-item prepend-icon="mdi-calendar-blank"> 
            {{ format(new Date(reservation.checkin), 'MMMM dd, yyyy') }} 
            <v-icon>mdi-arrow-right-thin</v-icon>
            {{ format(new Date(reservation.checkout), 'MMMM dd, yyyy') }}
         </v-list-item>
        <v-divider/>
        <!-- reservation status  -->
        <v-list-item>
            <p>Reservation status</p>
            <template v-slot:append>
                <p :class="reservation.status == 'approved' ? 'text-green' : 'text-orange'">{{reservation.status}}</p>
            </template>
         </v-list-item>
         <!-- price x days -->
         <v-list-item>
            ₱{{ parseInt(reservation.guesthouse.price).toLocaleString() }} x {{ reservation.days }} days
            <template v-slot:append>
                ₱{{ (reservation.guesthouse.price * ( reservation.days)).toLocaleString() }}
            </template>
         </v-list-item>
         <!-- if 30 days ipakita ni  -->
         <v-list-item v-if="reservation.days >= 30">
            Monthly stay discount
            <template v-slot:append>
                ₱{{  (( reservation.guesthouse.price * reservation.days) * (reservation.guesthouse.monthly_discount / 100)).toLocaleString()  }}
            </template>
         </v-list-item>
         <!-- total cost -->
         <v-list-item class="font-weight-bold">
            <p >Total cost</p>
            <template v-slot:append v-if="reservation.days >= 30">
                {{ `₱${((reservation.guesthouse.price * reservation.days) - ( reservation.guesthouse.price * reservation.days) * (reservation.guesthouse.monthly_discount / 100)).toLocaleString()}` }}
            </template>
            <template v-slot:append v-else>
                ₱{{ (reservation.guesthouse.price * (reservation.days)).toLocaleString() }}
            </template>

         </v-list-item>
        <v-divider/>
        <!-- cancel reservation and contact owner buttons -->
         <v-card-actions class="justify-end d-flex">
            <v-btn color="red" class="text-none" @click="openCancelReservationDialog">Cancel Reservation</v-btn>
            <Link :href="`/profile/${reservation.guesthouse.owner_id}`">
                <v-btn variant="flat" class="text-none" color="blue">Contact owner</v-btn>
            </Link>
         </v-card-actions>
    </v-card>
</template>