<script setup>

    import {ref, watch} from 'vue'
    import {format} from 'date-fns'
    import { router } from '@inertiajs/vue3'
    import AdminLayout from '../../Layouts/AdminLayout.vue'
    import emailjs from '@emailjs/browser'
    
    defineOptions({layout: AdminLayout})

    const entry = ref()
    const entries = [5, 10, 15, 20, 25]
    const statusColor = new Map([
        ['pending', 'orange'],
        ['approved', 'green'],
        ['cancelled', 'red']
    ])
    const {reservations} = defineProps({
        reservations: Object
    })

    function sendNotification(reservation) {
        console.log(reservation)

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
            alert('Email sent successfully!')
        })
    }

    
    watch(entry, () => {
        router.get(`/admin/manage-reservations/${entry.value}`)
    })

</script>
<template>
    <Head title="Reservations" />

        <v-row justify="space-between ms-4 mt-4">
            <v-col cols="2">
                    <v-select flat variant="solo-filled" v-model="entry" :items="entries" label="No. of entries"></v-select>
            </v-col>
            <v-col cols="4">
                <!-- <v-text-field  label="Search..." clearable variant="solo-filled" flat :loading="false" rounded></v-text-field> -->
            </v-col>
        </v-row>
        <v-table hover class="bg-grey-lighten-5 text-center ma-5">
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
                <tr v-if="reservations.length <= 0">
                    <td colspan="10"> No reservations.</td>
                </tr>
                <tr v-for="reservation in reservations.data" :key="reservation.id" v-else>
                    <td>{{ reservation.id }}</td>
                    <td>
                        <p v-if="reservation.listing">{{ reservation.listing.title }}</p>
                        <p v-else class="text-red">Guest house not found</p>
                    </td>
                    <td>
                        <v-list-item
                        v-if="reservation.user"
                        :title="reservation.user.firstname + ' ' + reservation.user.lastname"
                        ></v-list-item>
                        <p v-else class="text-red">User not found</p>
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
                    <v-chip :color="statusColor.get(reservation.status)">
                        {{ reservation.status }}
                    </v-chip>
                </td>
                <td>
                    
                    <v-btn @click="sendNotification(reservation)" size="small" :disabled="reservation.status != 'approved'" class="text-red text-none" variant="tonal" prepend-icon="mdi-bell">Notify
                        <v-tooltip activator="parent" location="top">
                            Alert owner and guest: reservation ending soon
                        </v-tooltip>
                    </v-btn>
                    
                    <!-- <v-btn icon="mdi-close" size="small" class="text-blue" flat></v-btn> -->
                    <!-- <v-btn icon="mdi-check" size="small" class="text-green" flat></v-btn> -->
                </td>
                </tr>
            </tbody>
        </v-table>
        <!-- <v-row  class="mt-2">
            <v-col class="d-flex justify-end">
                <v-pagination v-model="page" :length="10" :total-visible="4" rounded="circle">
                </v-pagination>
            </v-col>
        </v-row> -->
        <v-row  class="mt-2">
            <v-col class="d-flex justify-end">
                <Link 
                    v-for="link in reservations.links" 
                    :class="{ 'font-weight-bold' : link.active, 'mx-3' : link.url }" 
                    :key="link" 
                    :href="link.url"
                    v-html="link.label"
                    >
                </Link>
            </v-col>
        </v-row>
</template>