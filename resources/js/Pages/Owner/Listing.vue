<script setup>

    import Layout from '../../Layouts/OwnerLayout.vue'
    import {ref} from 'vue'
    const page = ref(1)
    const entries = [5, 10, 15, 20, 25]
    const entry = ref(5)


    defineOptions({
        layout: Layout
    })

    defineProps({
        guesthouses: Object
    })

</script>

<template>
    <v-container class="bg-white">
        <Link href="/owner/create-listing">
                <v-btn class="mt-2 mb-4 text-none" variant="outlined" prepend-icon="mdi-plus" color="blue">Create new listing</v-btn>
        </Link>
        <v-row justify="space-between">
            <v-col cols="2">
                    <v-select flat variant="solo-filled" v-model="entry" :items="entries" label="No. of entries"></v-select>
            </v-col>
            <v-col cols="4">
            <v-text-field  label="Search..." clearable variant="solo-filled" flat :loading="false" rounded></v-text-field>
        </v-col>
        </v-row>
        <v-table hover class="bg-grey-lighten-5 text-center">
            <thead>
                <tr>
                    <th class="text-center">Listing</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Guests</th>
                    <th class="text-center">Bathrooms</th>
                    <th class="text-center">Beds</th>
                    <th class="text-center">Location</th>
                    <th class="text-center">Created at</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="guesthouses.length <= 0">
                    <td colspan="8">No listings found.</td>
                </tr>
                <tr v-for="listing in guesthouses" :key="listing.id">
                    <td>
                        <v-list-item :title="listing.title">
                                <template v-slot:prepend>
                                    <v-avatar rounded="0" size="60">
                                    <v-img :src="`../images/room1.png`"></v-img>
                                </v-avatar>
                                </template>
                        </v-list-item>
                    </td>
                    <td>{{ listing.status }}</td>
                    <td>{{ listing.guests }}</td>
                    <td>{{ listing.bathrooms }}</td>
                    <td>{{ listing.beds }}</td>
                    <td>{{ listing.location }}</td>
                    <td>{{ listing.created_at }}</td>
                    <td>
                        <v-btn icon="mdi-delete-outline" size="small" class="text-red" flat></v-btn>
                        <v-btn icon="mdi-pencil" size="small" class="text-blue" flat></v-btn>
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
    </v-container>
</template>