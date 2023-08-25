<script setup>

    import {ref} from 'vue'
    import Layout from '../../shared/Layout.vue'
    defineOptions({layout: Layout})
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
                    <th class="text-center">Guest House</th>
                    <th class="text-center">Ambot</th>
                    <th class="text-center">Basta</th>
                    <th class="text-center">Location</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="n in 5" :key="n">
                    <td>{{ n }}</td>
                    <td>Guest House #{{ n }}</td>
                    <td>ambot {{ n }}</td>
                    <td>basta {{ n }}</td>
                    <td>Location {{ n }}</td>
                    <td>5/{{ n }}/2023</td>
                    <td>Pending</td>
                    <td>
                        <v-btn icon="mdi-delete" size="small" class="text-red" flat></v-btn>
                        <v-btn icon="mdi-close" size="small" class="text-blue" flat></v-btn>
                        <v-btn icon="mdi-check" size="small" class="text-green" flat></v-btn>
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
    </v-container>
</template>