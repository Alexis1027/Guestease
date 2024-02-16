<script setup>

    const {reservations} = defineProps({ reservations: Object })
    defineOptions({layout: AdminLayout})
    import {ref} from 'vue'
    import {format} from 'date-fns'
    import AdminLayout from '../../Layouts/AdminLayout.vue'
    import emailjs from '@emailjs/browser'
    
    const images = ref(null)
    const snackbar = ref(false)
    const notifyBtnLoading = ref(false)
    const reservationDialog = ref(false)
    const selectedReservation = ref(null)
    const statusColor = new Map([
        ['pending', 'orange'],
        ['approved', 'green'],
        ['cancelled', 'red']
    ])

    function showReservationDialog(reservation) {
        images.value = JSON.parse(reservation.listing.images)
        reservationDialog.value = true
        selectedReservation.value = reservation
        
    }

    function sendNotification(reservation) {
        console.log(reservation)
        notifyBtnLoading.value = true
        emailjs.send('service_kfsphbh', 'template_xzp03ja', 
        {
            sendername: "Guestease team",
            to: reservation.user.email,
            subject: "Reminder: Your Reservation Is Ending Soon",
            replyto: "guestease@team.com",
            message: `Dear ${reservation.user.firstname},

            This is a friendly reminder that your reservation for ${reservation.listing.title} is ending soon.

            Reservation Details:
            - Listing: ${reservation.listing.title}
            - Check-in Date: ${reservation.checkin}
            - Check-out Date: ${reservation.checkout}

            As your reservation is approaching its end date, please ensure that any necessary arrangements or extensions are made promptly if needed.

            If you have any questions or require assistance, please feel free to contact us.

            Thank you for choosing Guestease for your accommodation needs.

            Best regards,
            Admin
            Guestease Team`
            }
        , 'eEt-YCYeYc0LoTRxJ').then(() => {
            snackbar.value = true
            notifyBtnLoading.value = false
        })
    }

    const headers = [
        { title: 'ID', align: 'start', key: 'id', value: "id" },
        { title: 'Listing', align: 'start', key: 'listing.title', value: "listing.title" },
        { title: 'Guest', align: 'start', key: 'user.firstname', value: "user.firstname" },
        { title: 'Check-in/Check-out', align: 'start', key: 'price', value: "price" },
        { title: 'Total', align: 'start', key: 'total', value: "total" },
        { title: 'Guests', align: 'start', key: 'guests', value: "guests" },
        { title: 'Status', align: 'start', key: 'status', value: "status" },
        { title: 'Actions', align: 'start', key: 'actions', value: "actions" },
    ]

</script>
<template>
    <Head title="Reservations" />
    <v-container>
        <v-card title="Manage reservations">
            <v-data-table :items="reservations" :headers="headers">
                <template v-slot:item="{ item }">
                    <tr>
                        <td>{{ item.id }}</td>
                        <td>{{ item.listing.title }}</td>
                        <td>{{ item.user.firstname + " " + item.user.lastname }}</td>
                        <td>{{ format(new Date(item.checkin), 'MMM dd') + ' - ' + format(new Date(item.checkout), 'MMM dd')  }}</td>
                        <td>₱{{ parseInt(item.total).toLocaleString() }}</td>
                        <td>{{ item.guests }}</td>
                        <td>
                            <v-chip :color="statusColor.get(item.status)">
                                {{ item.status }}
                            </v-chip>
                        </td>
                        <td>
                            <v-btn size="small" @click="showReservationDialog(item)" class="me-2 text-none" color="blue" variant="tonal">View</v-btn>
                            <v-btn @click="sendNotification(item)" size="small" :disabled="item.status != 'approved'" class="text-red text-none" variant="tonal" prepend-icon="mdi-bell">Notify
                                <v-tooltip activator="parent" location="top">
                                    Alert guest: reservation ending soon
                                </v-tooltip>
                            </v-btn>
                        </td>
                    </tr>
                </template>
            </v-data-table> 
        </v-card>
    </v-container>

    <v-dialog v-model="reservationDialog">
        <v-card>
            <v-card-title>
                <v-list-item>
                    Reservation details
                    <template v-slot:append>
                        <v-btn icon="mdi-close" @click="reservationDialog = false" variant="text"></v-btn>
                    </template>
                </v-list-item>
            </v-card-title>
            <v-row>
                <v-col cols="12" md="7" sm="12" lg="7" xl="7" xxl="7">
                    <v-container>
                        <v-list>
                            <v-list-item prepend-icon="mdi-calendar">
                                <p class="font-weight-bold">Reservation dates</p>
                                <p>{{ `${format(new Date(selectedReservation.checkin), 'PP')} - ${format(new Date(selectedReservation.checkout), 'PP')}` }} </p>
                            </v-list-item>
                            <v-list-item prepend-icon="mdi-account-multiple">
                                <p class="font-weight-bold">Guests</p>
                                <p>{{ selectedReservation.guests }} {{ selectedReservation.guests <= 1 ? 'guest' : 'guests' }}</p>
                            </v-list-item>
                            <v-list-item>
                                <p class="font-weight-bold">Guest</p>
                                <template v-slot:prepend>
                                    <v-avatar>
                                        <v-img :src="`/images/Profile/${selectedReservation.user.profile_pic}`"></v-img>
                                    </v-avatar>
                                </template>
                                {{ selectedReservation.user.firstname +  ' ' + selectedReservation.user.lastname }}
                            </v-list-item>
                            <v-list-item prepend-icon="mdi-account-multiple">
                                <p class="font-weight-bold">Owner</p>
                                <template v-slot:prepend>
                                    <v-avatar>
                                        <v-img :src="`/images/Profile/${selectedReservation.owner.profile_pic}`"></v-img>
                                    </v-avatar>
                                </template>
                                {{ selectedReservation.owner.firstname +  ' ' + selectedReservation.owner.lastname }}
                            </v-list-item>
                        </v-list>
                        <v-divider  class="mb-4"/>

                        <p class="text-h6 mt-4 font-weight-bold">Payment method</p>
                        <v-list>
                            <v-list-item v-if="selectedReservation.payment_process == 'Gcash'" active-color="blue">
                                <template v-slot:prepend>
                                    <v-avatar>
                                        <v-img src="/images/icons/gcash2.png"></v-img>
                                    </v-avatar>
                                </template>
                                <p>Paid through Gcash</p>
                            </v-list-item>
                            <v-list-item active-color="blue" class="mt-6" v-else>
                                <template v-slot:prepend>
                                    <v-avatar>
                                        <v-img src="/images/icons/paypal2.png"></v-img>
                                    </v-avatar>
                                </template>
                                <p>Paid through Paypal</p>
                                <p class="text-none text-grey">Lorem ipsum dolor sit amet ndae cudwemque saepe!</p>
                            </v-list-item>
                        </v-list>
                    </v-container>
                </v-col>
                <v-divider vertical></v-divider>
                <v-col cols="12" md="5" lg="5" xl="5" xxl="5" sm="12">
                    <v-card class="justify-center" id="card">
                        <v-card width="400" max-height="300" class="mt-4" style="margin-left: 8%;">
                            <v-img :src="`/images/uploads/${images[0]}`" cover></v-img>
                        </v-card>
                        <v-card-title class="text-center font-weight-bold">
                            {{ selectedReservation.listing.title }}
                        </v-card-title>
                        <v-card-text>
                            <v-icon>mdi-map-marker</v-icon>
                            {{ selectedReservation.listing.location }}
                            <p>
                            {{ selectedReservation.listing.description }}
                            </p>
                        </v-card-text>
                        <v-divider/>
                        <v-card-text>
                            <p class="font-weight-bold text-center">Price Details</p>
                            <v-list-item>
                                <template v-slot:append>
                                    {{ `₱${(selectedReservation.listing.price * selectedReservation.days).toLocaleString()}` }}
                                </template>
                                {{ '₱'+ parseInt(selectedReservation.listing.price).toLocaleString()  }} x {{selectedReservation.days}} days
                            </v-list-item>
                            <v-list-item v-if="selectedReservation.days >= 30 && selectedReservation.listing.monthly_discount > 0">
                                <template v-slot:append>
                                    ₱{{  (( selectedReservation.listing.price * selectedReservation.days) * (selectedReservation.listing.monthly_discount / 100)).toLocaleString()  }}
                                </template>
                                Monthly stay discount
                            </v-list-item>
                            <v-divider/>
                            <v-list-item class="font-weight-bold">
                                <template v-slot:append v-if="selectedReservation.days >= 30">
                                    {{ `₱${((selectedReservation.listing.price * selectedReservation.days) - ( selectedReservation.listing.price * selectedReservation.days) * (selectedReservation.listing.monthly_discount / 100)).toLocaleString()}` }}
                                </template>
                                <template v-slot:append v-else>
                                    {{ `₱${((selectedReservation.listing.price * selectedReservation.days)).toLocaleString()}` }}
                                </template>
                                <p>Total</p>
                            </v-list-item>
                        </v-card-text>
                    </v-card>

                </v-col>
            </v-row>
        </v-card>
    </v-dialog>

    <v-snackbar v-model="snackbar">
        Email was sent successfully!
    </v-snackbar>

</template>

<style scoped>

    #hover:hover {
        text-decoration: underline;
    }

</style>