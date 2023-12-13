<script setup>

    import OwnerLayout from '../../Layouts/OwnerLayout.vue'
    import {ref} from 'vue'
    import {format} from 'date-fns'
    import { useForm } from '@inertiajs/vue3'
    import emailjs from '@emailjs/browser'
    import EditReservationStatusDialog from './Partials/EditReservationStatusDialog.vue'
    defineOptions({ layout: OwnerLayout })

    const props = defineProps(['reservations', 'auth'])
    const showEditReservationStatusDialog = ref(false)
    const selectedReservation = ref(null)
    const selectedStatus = ref(null)
    const snackbar = ref(false)
    const reportUserDialog = ref(false)
    const message = ref('')
    const selectedUser = ref(null)

    const statusColor = new Map([
        ['approved', 'green'],
        ['pending', 'orange'],
        ['cancelled', 'red'],
    ])

    const reportUserForm = useForm({
        user_id: null,
        reason: null,
    })

    function submitReportUserForm() {
        reportUserForm.post('/owner/report-user', {
            onSuccess: () => {
                message.value = "The guest has been reported."
                snackbar.value = true
                reportUserDialog.value = false
                reportUserForm.reset()
            }
        })
    }

    function showReportUserDialog(user) {
        selectedUser.value = user
        reportUserForm.user_id = user.id
        reportUserDialog.value = true
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

    const headers = [
        { title: 'Listing', align: 'start', key: 'title', value: "title" },
        { title: 'Guest', align: 'start', key: 'location', value: "location" },
        { title: 'Check-in/Check-out', align: 'start', key: 'price', value: "price" },
        { title: 'Reserved at', align: 'start', key: 'Reserved', value: "type" },
        { title: 'Total', align: 'start', key: 'Total', value: "type" },
        { title: 'Guests', align: 'start', key: 'Guests', value: "type" },
        { title: 'Status', align: 'start', key: 'status', value: "status" },
        { title: 'Actions', align: 'start', key: 'actions', value: "actions",sortable: false },
    ]

</script>

<template>
    <Head title="Reservations"/>
    <v-container>
        <v-data-table :items="reservations" :headers="headers">
            <template v-slot:item="{ item }">
                <tr>
                    <td>{{ item.listing.title }}</td>
                    <td>{{ item.user.firstname + " " + item.user.lastname }} 
                        <v-tooltip text="Report user" location="top">
                            <template v-slot:activator="{ props }">
                                <v-btn size="small" @click="showReportUserDialog(item.user)" v-bind="props" color="red" variant="text" icon="mdi-flag-variant"></v-btn> 
                            </template>
                        </v-tooltip>
                    </td>
                    <td>{{ format(new Date(item.checkin), 'MMM dd') + ' - ' + format(new Date(item.checkout), 'MMM dd') }}</td>
                    <td>{{ format(new Date(item.created_at), 'PP') }}</td>
                    <td>₱{{ parseInt(item.total).toLocaleString() }}</td>
                    <td>{{ item.guests }}</td>
                    <td>
                        <v-chip :color="statusColor.get(item.status)">
                            {{ item.status }}
                        </v-chip>
                    </td>
                    <td>
                        <v-menu>
                            <template v-slot:activator="{ props }">
                                <v-btn v-bind="props" append-icon="mdi-menu-down" size="small" class="me-2 text-none text-white" color="orange">Edit status</v-btn>
                            </template>
                            <v-list>
                                <v-btn variant="flat" @click="showEditReservationStatusDialogFn(item, 'approve')" block>Appove</v-btn>
                                <v-btn variant="flat" @click="showEditReservationStatusDialogFn(item, 'pending')" block>Set as pending</v-btn>
                                <v-btn variant="flat" @click="showEditReservationStatusDialogFn(item, 'cancel')" block>Cancel</v-btn>
                            </v-list>
                        </v-menu>
                        <v-btn @click="sendNotification(item)" size="small" :disabled="item.status != 'approved'" color="pink" class="text-none" prepend-icon="mdi-bell">
                            Notify
                            <v-tooltip activator="parent" location="top">
                                Notify guest: reservation ending soon
                            </v-tooltip>
                        </v-btn>
                    </td>
                </tr>
            </template>
        </v-data-table>
    </v-container>
    
    <v-snackbar v-model="snackbar" color="blue-lighten-3" timeout="1500">
        {{ message }}
        <template v-slot:actions>
            <v-btn variant="text" @click="snackbar = false" icon="mdi-close">
            </v-btn>
        </template>
    </v-snackbar>

    <v-dialog v-model="reportUserDialog" width="69%">
        <v-card title="Report guest">
            <v-divider class="mt-2" />
            <v-card-text>
                <v-list-item :title="selectedUser.firstname + ' ' + selectedUser.lastname" :subtitle="selectedUser.email">
                    <template v-slot:prepend>
                        <v-avatar size="60">
                            <v-img cover :src="`/images/profile/${selectedUser.profile_pic}`"></v-img>
                        </v-avatar>
                    </template>
                </v-list-item>
                <v-textarea label="Reason" v-model="reportUserForm.reason" :error-messages="reportUserForm.errors.reason" class="mt-2"></v-textarea>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="reportUserDialog = false">Close</v-btn>
                <v-btn color="red" @click="submitReportUserForm" :loading="reportUserForm.processing">Submit</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    
    <EditReservationStatusDialog :show="showEditReservationStatusDialog" @updateSuccessful="() => { message = 'Updated successfully' ; snackbar = true }" @closeEditReservationStatusDialog="showEditReservationStatusDialog = false" :selectedReservation="selectedReservation" :selectedStatus="selectedStatus"  />

</template>

<style>

    #datas td{
        padding: 10px;
    }

    #name:hover, #listing:hover {
        text-decoration: underline;
    }

</style>