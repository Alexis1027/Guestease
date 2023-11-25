<script setup>

    import {ref, defineProps, watch} from 'vue'
    import {router} from '@inertiajs/vue3'
    import AdminLayout from '../../Layouts/AdminLayout.vue'
    import DeleteListingDialog from './partials/DeleteListingDialog.vue'
    import {format} from 'date-fns'

    defineOptions({layout: AdminLayout})
    defineProps({listings: Object, newEntry: Object})
    
    const deleteListingDialog = ref(false)
    const deleteSnackbar = ref(false)
    const updateSnackbar = ref(false)
    const entries = [5, 10, 15, 20, 25]
    const entry = ref()
    const listing = ref({})

    function deleteListing(gh) {
        listing.value = gh
        deleteListingDialog.value = true
    }

    function updateListing(listing, status) {
        console.log(listing.id)
        router.put(`/admin/update-listing/${listing.id}`, {status}, {
            onSuccess:() => {
                updateSnackbar.value = true
            }
        })
    }

    watch(entry, () => {
        router.get(`/admin/manage-listings/${entry.value}`)
    })


</script>


<template>
    <Head title="Manage Listings" />
        <v-row justify="space-between ms-3 mt-4">
            <v-col cols="2">
                    <v-select flat variant="solo-filled" v-model="entry" :items="entries" label="No. of entries"></v-select>
            </v-col>
            <v-col cols="4">
            <!-- <v-text-field  label="Search..." clearable variant="solo-filled" flat :loading="false" rounded></v-text-field> -->
        </v-col>
        </v-row>
        <v-table hover class="bg-grey-lighten-5 text-center ma-4">
        <thead>
            <tr >
                <th class="text-center">ID</th>
                <th class="text-center">Owner</th>
                <!-- <th class="text-center">Image</th> -->
                <th class="text-center">Listing name</th>
                <th class="text-center">Location</th>
                <th class="text-center">Type</th>
                <th class="text-center">Price</th>
                <th class="text-center">Created at</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <v-slide-x-transition group>
                <tr v-for="listing in listings.data" :key="listing.id" class="pa-4">
                    <td>{{ listing.id }}</td>
                    <td class="pa-4 text-start">
                        <v-list-item :title="listing.owner.firstname + ' ' + listing.owner.lastname" :prepend-avatar="`/images/profile/${listing.owner.profile_pic}`"></v-list-item>
                    </td>
                    <!-- <td class="text-red"> 
                        <v-img cover max-height="80" height="80" class="my-1" :src="`/images/uploads/${JSON.parse(listing.images)[0]}`"></v-img>
                     </td> -->
                    <td>{{ listing.title }}</td>
                    <td>{{ listing.location }}</td>
                    <td>{{ listing.type }}</td>
                    <td> {{ '₱'+parseInt(listing.price).toLocaleString() }} </td>
                    <td>{{ format(new Date(listing.created_at), 'M/d/yyy') }}</td>
                    <td>
                        <v-menu open-on-hover>
                            <template v-slot:activator="{ props }">
                                <v-btn color="blue" :disabled="listing.status == 'For approval'" append-icon="mdi-menu-down" class="text-none" variant="tonal" v-bind="props">
                                    {{ listing.status }}
                                </v-btn>
                            </template>

                            <v-list>
                                <v-list-item prepend-icon="mdi-check" title="Available" @click="updateListing(listing, 'Available')">
                                </v-list-item>
                                <v-list-item prepend-icon="mdi-close" title="Not available" @click="updateListing(listing, 'Not available')">
                                </v-list-item>
                                <v-list-item prepend-icon="mdi-delete-outline" title="Delete listing" @click="deleteListing(listing)" base-color="red">
                                </v-list-item>
                            </v-list>
                        </v-menu>
                        
                    </td>
                </tr>
            </v-slide-x-transition>
            <tr v-if="listings.data.length <= 0">
                <td class="text-h6" colspan="6">No listing found.</td>
            </tr>
        </tbody>
    </v-table>
    <v-row  class="mt-2">
        <v-col class="d-flex justify-end">
            <Link 
                v-for="link in listings.links" 
                :class="{ 'font-weight-bold' : link.active, 'mx-3' : link.url }" 
                :key="link" 
                :href="link.url"
                v-html="link.label"
                >
            </Link>
        </v-col>
    </v-row>
    

    <DeleteListingDialog :listing="listing" @showDeleteSuccessfulSnackbar="deleteSnackbar = true" :show="deleteListingDialog" @CloseDialog="deleteListingDialog = false" v-model="deleteListingDialog" />

    <v-snackbar v-model="deleteSnackbar" color="red-lighten-3" timeout="1500" >
        Deleted successfully
        <template v-slot:actions>
            <v-btn variant="text" @click="deleteSnackbar = false" icon="mdi-close">
            </v-btn>
        </template>
    </v-snackbar>

    <v-snackbar v-model="updateSnackbar" color="blue-lighten-3" timeout="1500">
        Updated successfully
        <template v-slot:actions>
            <v-btn variant="text" @click="updateSnackbar = false" icon="mdi-close">
            </v-btn>
        </template>
    </v-snackbar>

</template>

<style scoped>

    .v-table, th, td {
        border: 1px solid rgb(238,238,238);
    }

</style>
