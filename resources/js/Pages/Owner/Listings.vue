<script setup>

    import Layout from '../../Layouts/OwnerLayout.vue'
    import {ref} from 'vue'
    import {format} from 'date-fns'
    import DeleteListingDialog from './Partials/DeleteListingDialog.vue'

    const page = ref(1)
    const entries = [5, 10, 15, 20, 25]
    const entry = ref(5)
    const listingToDelete = ref(null)
    const deleteListingDialog = ref(false)
    function deleteListing(listing) {
        listingToDelete.value = listing
        deleteListingDialog.value = true
    }

    defineOptions({ layout: Layout })
    defineProps({ listings: Object })

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
                    <th class="text-center">Property</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Location</th>
                    <th class="text-center">Created at</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="listings.length <= 0">
                    <td colspan="8">No listings found.</td>
                </tr>
                <tr v-for="listing in listings" :key="listing.id">
                    <td>
                        <v-list-item :title="listing.title">
                                <template v-slot:prepend>
                                    <v-avatar rounded="0" size="60">
                                        <v-img :src="`../images/${JSON.parse(listing.images)[0]}`" cover></v-img>
                                    </v-avatar>
                                </template>
                        </v-list-item>
                    </td>
                    <td>{{ listing.status }}</td>
                    <td>
                        <v-menu open-on-hover>
                            <template v-slot:activator="{ props }">
                                <v-btn color="black" append-icon="mdi-menu-down" class="text-none" variant="text" v-bind="props">
                                    Details
                                </v-btn>
                            </template>

                            <v-list>
                                <v-list-item>
                                    {{ listing.guests }} Guests
                                </v-list-item>
                                <v-list-item>
                                    {{ listing.beds }} Bedrooms
                                </v-list-item>
                                <v-list-item>
                                    {{ listing.rooms }} Rooms
                                </v-list-item>
                                <v-list-item>
                                    {{ listing.bathrooms }} Bathrooms
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </td>
                    <td>₱{{ parseInt(listing.price).toLocaleString() }}</td>
                    
                    <td>{{ listing.location }}</td>
                    <td>{{ format(new Date(listing.created_at), 'M/d/y') }}</td>
                    <td>
                        
                        <!-- <v-btn icon="mdi-check" size="small" class="text-green" flat></v-btn> -->
                        <v-menu open-on-hover>
                            <template v-slot:activator="{ props }">
                                <v-btn color="grey-darken-2" icon="mdi-cog" class="text-none" variant="text" v-bind="props">
                                </v-btn>
                            </template>

                            <v-list>
                                <Link :href="`/owner/edit-listing/${listing.id}`">
                                    <v-list-item prepend-icon="mdi-pencil" title="Edit" value="edit-listing" base-color="blue">
                                    </v-list-item>
                                </Link>
                                <v-list-item prepend-icon="mdi-delete-outline" title="Delete" @click="deleteListing(listing)" base-color="red">
                                </v-list-item>
                                
                            </v-list>
                        </v-menu>
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
    <DeleteListingDialog :show="deleteListingDialog" :listing="listingToDelete" @CloseDialog="deleteListingDialog = false" />
</template>