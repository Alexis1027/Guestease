<script setup>

    const {reservations} = defineProps({ reservations: Object })
    defineOptions({layout: AdminLayout})
    import {ref} from 'vue'
    import {format} from 'date-fns'
    import AdminLayout from '../../Layouts/AdminLayout.vue'
    import emailjs from '@emailjs/browser'
    
    const snackbar = ref(false)
    const notifyBtnLoading = ref(false)

    const statusColor = new Map([
        ['pending', 'orange'],
        ['approved', 'green'],
        ['cancelled', 'red']
    ])

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

    <v-snackbar v-model="snackbar">
        Email was sent successfully!
    </v-snackbar>

</template>

<style scoped>

    #hover:hover {
        text-decoration: underline;
    }

</style>