<script setup>

    import OwnerLayout from '../../Layouts/OwnerLayout.vue'
    import {ref, watch} from 'vue'
    import {format} from 'date-fns'
    import {router} from '@inertiajs/vue3'
    import emailjs from '@emailjs/browser'
    import EditReservationStatusDialog from './Partials/EditReservationStatusDialog.vue'

    const props = defineProps(['reservations', 'auth'])
    const page = ref(1)
    const entries = [5, 10, 15, 20, 25]
    const entry = ref(5)
    const showEditReservationStatusDialog = ref(false)
    const selectedReservation = ref(null)
    const selectedStatus = ref(null)

    const statusColor = new Map([
        ['approved', 'green'],
        ['pending', 'orange'],
        ['cancelled', 'red'],
    ])

    function updateReservation(reservation, status) {
        router.put(`/owner/update-reservation/${reservation.id}`, {
            status: status,
            listing_id: reservation.listing_id
        })
    }

    function showEditReservationStatusDialogFn(reservation, status) {
        showEditReservationStatusDialog.value = true
        selectedReservation.value = reservation
        selectedStatus.value = status
    }

    function sendNotification(reservation) {
        console.log(reservation)

        emailjs.send('service_kfsphbh', 'template_xzp03ja', 
        {
            sendername: `${props.auth.user.firstname} ${props.auth.user.lastname}`,
            to: reservation.user.email,
            subject: "Reminder: Your Reservation Is Ending Soon",
            replyto: `${props.auth.user.email}`,
            message: `Dear ${reservation.user.firstname},

            This is a friendly reminder that your reservation for ${reservation.listing.title} is ending soon.

            Reservation Details:
            - Listing: ${reservation.listing.title}
            - Check-in Date: ${reservation.checkin}
            - Check-out Date: ${reservation.checkout}

            As your reservation is approaching its end date, please ensure that any necessary arrangements or extensions are made promptly if needed.

            If you have any questions or require assistance, please feel free to contact us.

            Best regards,
            ${props.auth.user.firstname} ${props.auth.user.lastname}`
            }
        , 'eEt-YCYeYc0LoTRxJ').then(() => {

            alert('Email sent successfully!')
        })
    }

    watch(entry, () => {
        router.get(`/owner/reservations/${entries.value}`)
    })

    defineOptions({
        layout: OwnerLayout
    })
</script>

<template>
    <v-row justify="space-between" class="pa-4">
        <v-col cols="2">
                <v-select flat variant="solo-filled" v-model="entry" :items="entries" label="No. of entries"></v-select>
        </v-col>
    </v-row>
    <v-table hover class="bg-grey-lighten-5 text-center ma-4">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Listing</th>
                <th class="text-center">Guest</th>
                <th class="text-center">Guest info</th>
                <th class="text-center">Check-in/Check-out</th>
                <th class="text-center">Reserved at</th>
                <th class="text-center">Total cost</th>
                <th class="text-center">Guests</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="reservation in reservations" :key="reservation.id" id="datas" style="font-size: 15px;">
                <td>{{ reservation.id }}</td>
                <td>
                    <Link :href="`/owner/edit-listing/${reservation.listing.id}`">
                        <v-list-item id="listing" class="text-capitalize" :prepend-avatar="`/images/uploads/${JSON.parse(reservation.listing.images)[0]}`">
                            {{ reservation.listing.title }}
                        </v-list-item>
                    </Link>
                </td>
                <td>
                    <Link :href="`/profile/${reservation.user.id}`">
                        <v-list-item class="text-capitalize" id="name"> {{ reservation.user.firstname + ' ' + reservation.user.lastname }}</v-list-item>
                    </Link>
                </td>
                <td>
                    <v-list-item>
                        {{ reservation.user.phone_number }}
                        <v-divider/>
                        {{ reservation.user.email }}
                    </v-list-item>
                </td>
                <td>
                    {{ format(new Date(reservation.checkin), 'MMM dd') + ' - ' + format(new Date(reservation.checkout), 'MMM dd')  }}
                    <v-divider/>
                    Length: {{ reservation.days }} days
                </td>
                <td>{{ format(new Date(reservation.created_at), 'y/M/d') }}</td>
                <td>₱{{ parseInt(reservation.total).toLocaleString() }}</td>
                <td>{{ reservation.guests }}</td>
                <td>
                    <v-menu open-on-hover>
                        <template v-slot:activator="{ props }">
                            <v-btn :color="statusColor.get(reservation.status)" append-icon="mdi-menu-down" class="text-none" variant="tonal" v-bind="props">
                                {{ reservation.status }}
                            </v-btn>
                        </template>

                        <v-list>
                            <v-list-item prepend-icon="mdi-check" title="approve" @click="showEditReservationStatusDialogFn(reservation, 'approve')">
                            </v-list-item>
                            <v-list-item prepend-icon="mdi-close" title="pending" @click="showEditReservationStatusDialogFn(reservation, 'pending')">
                            </v-list-item>
                            <v-list-item prepend-icon="mdi-delete-outline" title="cancel" @click="showEditReservationStatusDialogFn(reservation, 'cancel')" base-color="red">
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </td>
                <td>
                    <v-btn @click="sendNotification(reservation)" size="small" :disabled="reservation.status != 'approved'" class="text-red text-none" variant="tonal" prepend-icon="mdi-bell">Notify
                        <v-tooltip activator="parent" location="top">
                            Notify guest reservation ending soon
                        </v-tooltip>
                    </v-btn>
                </td>
            </tr>
            <tr v-if="reservations.length <= 0">
                <td colspan="10"> No reservations yet.</td>
            </tr>
        </tbody>
    </v-table>
    <v-row  class="mt-2">
        <v-col class="d-flex justify-end">
            <!-- <Link 
                v-for="link in prop.users.links" 
                :class="{ 'font-weight-bold' : link.active, 'mx-3' : link.url }" 
                :key="link" 
                :href="link.url"
                v-html="link.label"
                >
            </Link> -->
            <v-pagination
            v-model="page"
            :length="10"
            :total-visible="4"
            rounded="circle"
            ></v-pagination>
        </v-col>
    </v-row>

    <EditReservationStatusDialog :show="showEditReservationStatusDialog" @closeEditReservationStatusDialog="showEditReservationStatusDialog = false" :selectedReservation="selectedReservation" :selectedStatus="selectedStatus"  />

</template>

<style>

    #datas td{
        padding: 10px;
    }

    #name:hover, #listing:hover {
        text-decoration: underline;
    }

</style>