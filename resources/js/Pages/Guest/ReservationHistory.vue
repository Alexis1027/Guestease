<script setup>

    import GuestLayout from '../../Layouts/GuestLayout.vue'
    import {ref} from 'vue'
    import {format} from 'date-fns'

    const tab = ref(null)

    defineOptions({
        layout: GuestLayout
    })

</script>
<template>
    <v-container>
        <h1>Reservation History</h1>
            <v-table hover class="bg-grey-lighten-5 text-center">
                <thead >
                    <tr >
                        <th class="text-center">ID</th>
                        <th class="text-center">Owner</th>
                        <th class="text-center">Listing</th>
                        <th class="text-center">Check-in/Check-out</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <v-slide-x-transition class="py-0" group>
                        <tr v-for="n in 5" :key="n">
                            <td>{{ n }}</td>
                            <td>{{ "john doe " + n }}</td>
                            <td>{{ "Listing " + n }}</td>
                            <td>{{ format(new Date(), 'MMM dd') }} -  {{ format(new Date(), 'MMM dd, yyyy') }} </td>
                            <td> <v-chip size="small" :color="n%2==0?'red':'green'">{{ n%2==0?"cancelled":"completed" }}</v-chip> </td>
                            <td>
                                <v-btn size="small" class="text-red bg-grey-lighten-5 text-none ms-1" variant="tonal"> 
                                     Delete
                                </v-btn>
                                <!-- <v-btn icon="mdi-close" size="small" class="text-blue" flat></v-btn> -->
                                <!-- <v-btn icon="mdi-check" size="small" class="text-green" flat></v-btn> -->
                            </td>
                        </tr>
                        
                    </v-slide-x-transition>
                </tbody>
            </v-table>
    </v-container>
</template>