<script setup>

    import {ref} from 'vue'
    import {format} from 'date-fns'
    import Layout from '../../shared/Layout.vue'
    defineOptions({layout: Layout})
    const {reservations} = defineProps({
        reservations: Object
    })

    const page = ref(1)
    const entries = [5, 10, 15, 20, 25]
    const entry = ref(5)

</script>
<template>
    <Head title="Reservations" />

    <v-container class="bg-white">
        <v-row justify="space-between">
            <v-col cols="2">
                    <v-select flat variant="solo-filled" v-model="entry" :items="entries" label="No. of entries"></v-select>
            </v-col>
            <v-col cols="4">
            <v-text-field  label="Search..." clearable variant="solo-filled" flat :loading="false" rounded></v-text-field>
        </v-col>
        </v-row>
        <v-table hover class="bg-grey-lighten-5 text-center">
            <thead >
                <tr >
                    <th class="text-center">Id</th>
                    <th class="text-center">Guest house id</th>
                    <th class="text-center">Guest id</th>
                    <th class="text-center">Payment Process</th>
                    <th class="text-center">Reserved at</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="reservation in reservations" :key="reservation.id">
                    <td>{{ reservation.id }}</td>
                    <td>{{ reservation.room_id }}</td>
                    <td>{{ reservation.user_id }}</td>
                    <td>{{ reservation.payment_process }}</td>
                    <td>{{ format(new Date(reservation.created_at), 'M/dd/yyyy') }}</td>
                    <td>{{ reservation.status }}</td>
                    <td>
                        <v-btn icon="mdi-delete-outline" size="small" class="text-red" flat></v-btn>
                        <!-- <v-btn icon="mdi-close" size="small" class="text-blue" flat></v-btn> -->
                        <!-- <v-btn icon="mdi-check" size="small" class="text-green" flat></v-btn> -->
                    </td>
                </tr>
                <tr v-if="reservations.length <= 0">
                    <td colspan="8"> No reservations.</td>
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
    </v-container>
</template>