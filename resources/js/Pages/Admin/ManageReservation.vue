<script setup>

    import {ref, watch} from 'vue'
    import {format} from 'date-fns'
    import { router } from '@inertiajs/vue3'
    import AdminLayout from '../../Layouts/AdminLayout.vue'
    
    defineOptions({layout: AdminLayout})

    const entry = ref()
    const page = ref(1)
    const entries = [5, 10, 15, 20, 25]
    const {reservations} = defineProps({
        reservations: Object
    })
    
    watch(entry, () => {
        router.get(`/admin/manage-reservations/${entry.value}`)
    })

</script>
<template>
    <Head title="Reservations" />

        <v-row justify="space-between">
            <v-col cols="2">
                {{ entry }}
                    <v-select flat variant="solo-filled" v-model="entry" :items="entries" label="No. of entries"></v-select>
            </v-col>
            <v-col cols="4">
                <!-- <v-text-field  label="Search..." clearable variant="solo-filled" flat :loading="false" rounded></v-text-field> -->
            </v-col>
        </v-row>
        <v-table hover class="bg-grey-lighten-5 text-center">
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
                    <td colspan="8"> No reservations.</td>
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
                <td>{{ reservation.status }}</td>
                <td>
                    <v-btn size="small" class="text-red text-none" variant="tonal">Button</v-btn>
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