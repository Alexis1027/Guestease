<script setup>

    import OwnerLayout from '../../Layouts/OwnerLayout.vue'
    import {ref} from 'vue'
    import {format} from 'date-fns'
    import {router} from '@inertiajs/vue3'

    const props = defineProps(['reservations'])
    const page = ref(1)
    const entries = [5, 10, 15, 20, 25]
    const entry = ref(5)

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
                            <v-list-item prepend-icon="mdi-check" title="approve" @click="updateReservation(reservation, 'approved')">
                            </v-list-item>
                            <v-list-item prepend-icon="mdi-close" title="pending" @click="updateReservation(reservation, 'pending')">
                            </v-list-item>
                            <v-list-item prepend-icon="mdi-delete-outline" title="cancel" @click="updateReservation(reservation, 'cancelled')" base-color="red">
                            </v-list-item>
                        </v-list>
                    </v-menu>
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
</template>

<style>

    #datas td{
        padding: 10px;
    }

    #name:hover, #listing:hover {
        text-decoration: underline;
    }

</style>