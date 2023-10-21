<script setup>

    import OwnerLayout from '../../Layouts/OwnerLayout.vue'
    import {ref} from 'vue'
    import {format} from 'date-fns'
    const props = defineProps(['reservations'])
    defineOptions({
        layout: OwnerLayout
    })

    const page = ref(1)
    const entries = [5, 10, 15, 20, 25]
    const entry = ref(5)

</script>

<template>
    <v-row justify="space-between" class="pa-4">
        <v-col cols="2">
                <v-select flat variant="solo-filled" v-model="entry" :items="entries" label="No. of entries"></v-select>
        </v-col>
        <v-col cols="4">
            <v-text-field  label="Search..." clearable variant="solo-filled" flat :loading="false" rounded></v-text-field>
        </v-col>
    </v-row>
    <v-table hover class="bg-grey-lighten-5 text-center ma-4">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Listing</th>
                <th class="text-center">Guest info</th>
                <th class="text-center">Check-in/Check-out</th>
                <th class="text-center">Reserved at</th>
                <th class="text-center">Price</th>
                <th class="text-center">Guests</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="reservation in reservations" :key="reservation.id" id="datas">
                <td>{{ reservation.id }}</td>
                <td>
                    <v-list-item 
                    :prepend-avatar="`../../images/${JSON.parse(reservation.listing.images)[0]}`" 
                    :title="reservation.listing.title">
                    </v-list-item>
                </td>
                <td>
                    <v-list-item 
                    :prepend-avatar="`../../images/profile/${reservation.user.profile_pic}`" 
                    :title="reservation.user.firstname + ' ' + reservation.user.lastname" 
                    :subtitle="reservation.user.email">
                    </v-list-item>
                </td>
                <td>
                    {{ format(new Date(reservation.checkin), 'MMM dd') + ' - ' + format(new Date(reservation.checkout), 'MMM dd')  }}
                    <br>
                    {{ reservation.days }} days
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

</style>