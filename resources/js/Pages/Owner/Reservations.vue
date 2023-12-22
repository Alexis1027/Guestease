<script setup>

    import OwnerLayout from '../../Layouts/OwnerLayout.vue'
    import {ref} from 'vue'
    import {format} from 'date-fns'
    import { useForm, router } from '@inertiajs/vue3'
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
    const deleteReservationDialog = ref(false)
    const reservationDetailsDialog = ref(false)

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

    function deleteReservation() {
        router.delete(`/owner/delete-reservation/${selectedReservation.value.id}`, {
            onSuccess: () => {
                deleteReservationDialog.value = false
                snackbar.value = true
                message.value = 'Reservation deleted successfully'
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

    function showReservationDetailsDialog(reservation) {
        selectedReservation.value = reservation
        reservationDetailsDialog.value = true
    }

    function showDeleteReservationDialog(reservation) {
        selectedReservation.value = reservation
        deleteReservationDialog.value = true
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
            snackbar.value = true
            message.value = 'Email sent successfully!'
        })
    }

    const headers = [
        { title: 'Listing', align: 'start', key: 'title', value: "title" },
        { title: 'Guest', align: 'start', key: 'user.firstname', value: "user.firstname" },
        { title: 'Check-in/Check-out', align: 'start', key: 'checkin', value: "checkin" },
        { title: 'Reserved at', align: 'start', key: 'Reserved', value: "type" },
        { title: 'Total', align: 'start', key: 'total', value: "total" },
        { title: 'Guests', align: 'start', key: 'guests', value: "guests" },
        { title: 'Status', align: 'start', key: 'status', value: "status" },
        { title: 'Actions', align: 'start', key: 'actions', value: "actions", sortable: false },
    ]

</script>

<template>
    <Head title="Reservations"/>
    <v-card class="ma-2" title="Manage reservations">
        <v-data-table :items="reservations" :headers="headers" hover>
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
                    <td>{{ format(new Date(item.checkin), 'PP') + ' - ' + format(new Date(item.checkout), 'PP') }}</td>
                    <td>{{ format(new Date(item.created_at), 'PP') }}</td>
                    <td>₱{{ parseInt(item.total).toLocaleString() }}</td>
                    <td>{{ item.guests }}</td>
                    <td>
                        <v-chip :color="statusColor.get(item.status)">
                            {{ item.status }}
                        </v-chip>
                    </td>
                    <td>

                        <v-tooltip location="bottom">
                            <template v-slot:activator="{ props }">
                                <v-btn icon="mdi-eye-outline" variant="tonal" color="blue" class="me-2" size="small" @click="showReservationDetailsDialog(item)" v-bind="props"></v-btn>
                            </template>
                            <span>View reservation details</span>
                        </v-tooltip>

                        <v-tooltip location="bottom" v-if="item.status == 'pending'">
                            <template v-slot:activator="{ props }">
                                <v-btn icon="mdi-check" color="green" variant="tonal" class="me-2" size="small" @click="showEditReservationStatusDialogFn(item, 'approve')" v-bind="props"></v-btn>
                            </template>
                            <span>Approve reservation</span>
                        </v-tooltip>
                        
                        <v-tooltip location="bottom" v-if="item.status == 'pending'">
                            <template v-slot:activator="{ props }">
                                <v-btn icon="mdi-close" class="me-2" variant="tonal" color="red" size="small" @click="showEditReservationStatusDialogFn(item, 'cancel')" v-bind="props"></v-btn>
                            </template>
                            <span>Cancel reservation</span>
                        </v-tooltip>

                        <v-tooltip location="bottom" v-if="item.status == 'cancelled'">
                            <template v-slot:activator="{ props }">
                                <v-btn icon="mdi-delete-empty-outline" variant="tonal" color="red" class="me-2" size="small" @click="showDeleteReservationDialog(item)" v-bind="props"></v-btn>
                            </template>
                            <span>Delete reservation</span>
                        </v-tooltip>

                        <v-tooltip location="bottom" v-if="item.status == 'approved'">
                            <template v-slot:activator="{ props }">
                                <v-btn icon="mdi-bell-outline" color="pink" variant="tonal" class="me-2" size="small" @click="sendNotification(item)" v-bind="props"></v-btn>
                            </template>
                            <span>Remind guest reservation ending soon via email</span>
                        </v-tooltip>


                        <!-- <v-menu>
                            <template v-slot:activator="{ props }">
                                <v-btn v-bind="props" append-icon="mdi-menu-down" size="small" class="me-2 text-none text-white" color="orange">Edit status</v-btn>
                            </template>
                            <v-list>
                                <v-btn variant="flat" @click="showEditReservationStatusDialogFn(item, 'approve')" block>Appove</v-btn>
                                <v-btn variant="flat" @click="showEditReservationStatusDialogFn(item, 'pending')" block>Set as pending</v-btn>
                                <v-btn variant="flat" @click="showEditReservationStatusDialogFn(item, 'cancel')" block>Cancel</v-btn>
                            </v-list>
                        </v-menu>
                        <v-btn @click="sendNotification(item)" size="small" v-if="item.status != 'cancelled'" :disabled="item.status != 'approved'" color="pink" class="text-none" prepend-icon="mdi-bell">
                            Notify
                            <v-tooltip activator="parent" location="top">
                                Notify guest: reservation ending soon
                            </v-tooltip>
                        </v-btn>
                        <v-btn @click="deleteReservationDialog = true" v-if="item.status == 'cancelled'" size="small" color="red" class="text-none" prepend-icon="mdi-delete-empty-outline">
                            Delete
                            <v-tooltip activator="parent" location="top">
                                Notify guest: reservation ending soon
                            </v-tooltip>
                        </v-btn> -->
                    </td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
    
    <v-snackbar v-model="snackbar" color="blue-lighten-3" timeout="1500">
        {{ message }}
        <template v-slot:actions>
            <v-btn variant="text" @click="snackbar = false" icon="mdi-close">
            </v-btn>
        </template>
    </v-snackbar>

    <v-dialog v-model="deleteReservationDialog" width="50%">
        <v-card title="Delete reservation">
            <v-card-item>
                <v-alert icon="mdi-alert" color="red-lighten-4" elevation="2" class="text-start text-error">
                        After you delete a reservation, it's permanently deleted. Reservations can't be undeleted.
                    </v-alert>
            </v-card-item>
            <v-row>
                <v-col cols="6">
                    <p class="ma-4  text-body-2 text-start">
                        Listing <br>
                        <strong class="text-h6">{{ selectedReservation.listing.title }}</strong>
                    </p>    
                </v-col>
                <v-col cols="6">
                    <p class="ma-4  text-body-2 text-start">
                        Guest <br>
                        <strong class="text-h6">{{ selectedReservation.user.firstname + ' ' + selectedReservation.user.lastname }}</strong>
                    </p>
                </v-col>
            </v-row>
            <p class="mx-4 text-body-2 text-start">
                Check-in / Check-out <br>
                <strong class="text-h6">{{ format(new Date(selectedReservation.checkin), 'PPP') + ' - ' + format(new Date(selectedReservation.checkout), 'PPP') }}</strong>
            </p>
            <p class="ma-4 text-body-2 text-start">
                Status <br>
                <strong class="text-h6 text-capitalize">{{ selectedReservation.status }}</strong>
            </p>
            <v-card-actions>
                <v-spacer/>
                <v-btn @click="deleteReservationDialog = false" class="text-none">Cancel</v-btn>
                <v-btn color="red" variant="flat" class="text-none" @click="deleteReservation">Delete</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="reservationDetailsDialog" width="69%">
        <v-card title="Reservation details">
            <v-row>
                <v-col cols="6">
                    <p class="ma-4  text-body-2 text-start">
                        Listing <br>
                        <strong class="text-h6">{{ selectedReservation.listing.title }}</strong>
                    </p>    
                </v-col>
                <v-col cols="6">
                    <p class="ma-4  text-body-2 text-start">
                        Guest <br>
                        <strong class="text-h6">{{ selectedReservation.user.firstname + ' ' + selectedReservation.user.lastname }}</strong>
                    </p>
                </v-col>
            </v-row>
            <p class="mx-4 text-body-2 text-start">
                Check-in / Check-out <br>
                <strong class="text-h6">{{ format(new Date(selectedReservation.checkin), 'PPP') + ' - ' + format(new Date(selectedReservation.checkout), 'PPP') }}</strong>
            </p>
            <p class="ma-4 text-body-2 text-start">
                Status <br>
                <strong class="text-h6 text-capitalize">{{ selectedReservation.status }}</strong>
            </p>
                <p class="mx-4 text-body-2 text-start">
                    Payment details <br>
                    <strong class="text-h6 text-capitalize">{{ selectedReservation.payment_process }}</strong>
                </p>
                <v-img v-if="selectedReservation.payment_process == 'Gcash'" :src="`/images/payment_screenshots/${selectedReservation.payment_screenshot}`" cover height="369" width="369" style="margin: auto"></v-img>
            <v-card-actions>
                <v-spacer/>
                <v-btn @click="reservationDetailsDialog = false">Close</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

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