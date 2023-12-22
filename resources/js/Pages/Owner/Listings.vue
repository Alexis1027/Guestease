<script setup>

    import OwnerLayout from '../../Layouts/OwnerLayout.vue'
    import {ref} from 'vue'
    import {useForm, router} from '@inertiajs/vue3'
    import {format} from 'date-fns'
    import MazGallery from 'maz-ui/components/MazGallery'
    import DeleteListingDialog from './Partials/DeleteListingDialog.vue'

    defineOptions({ layout: OwnerLayout })
    defineProps({ listings: Object, auth: Object })

    const deleteListingDialog = ref(false)
    const snackbar = ref(false)
    const viewListingDialog = ref(false)
    const updateStatusDialog = ref(false)
    const listingImages = ref(null)
    const selectedListing = ref(null)
    const message = ref('')

    const updateListingStatusForm = useForm({
        id: null,
        status: null,
        title: null
    })

    
    function updateListing() {
        updateListingStatusForm.put(`/owner/update-listing/status/${updateListingStatusForm.id}`, {
            onSuccess: () => {
                snackbar.value = true
                message.value = "Successfully updated status."
                updateStatusDialog.value = false
            }
        })
    }

    const deleteListing = () => {
        router.delete(`/owner/delete-listing/${selectedListing.value.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                snackbar.value = true
                deleteListingDialog.value = false
                message.value = "Listing deleted successfully."
            }
        })
    }

    function showViewListingDialog(listing) {
        selectedListing.value = listing
        viewListingDialog.value = true
        const images = JSON.parse(listing.images)
        console.log(images)
        console.log(listing.images)
        listingImages.value = images.map(img => '/images/uploads/' + img)

    }

    function showUpdateStatusDialog(listing) {
        updateListingStatusForm.id = listing.id
        updateListingStatusForm.status = listing.status
        updateListingStatusForm.title = listing.title
        updateStatusDialog.value = true
    }

    function showDeleteListingDialog(listing) {
        selectedListing.value = listing
        deleteListingDialog.value = true
    }

    const statusColor = new Map([
        ['For approval', 'orange'],
        ['Available', 'green'],
        ['Not available', 'red'],
        ['Rejected', 'red'],
    ])

    const headers = [
        { title: 'Title', align: 'start', key: 'title', value: "title" },
        { title: 'Location', align: 'start', key: 'location', value: "location" },
        { title: 'Price', align: 'start', key: 'price', value: "price" },
        { title: 'Type', align: 'start', key: 'type', value: "type" },
        { title: 'Status', align: 'start', key: 'status', value: "status" },
        { title: 'Actions', align: 'start', key: 'actions', value: "actions" },
    ]

</script>

<template>
    <Head title="Listings"/>
    
    <v-card class="ma-2">
        <template v-slot:title>
            <v-row justify="space-between">
            <v-col>
                <p>Manage Listings</p>
            </v-col>
            <v-col class="justify-end d-flex">
                <Link href="/owner/create-listing">
                    <v-btn class="text-none" variant="flat" prepend-icon="mdi-plus" color="blue">Add new listing</v-btn>
                </Link>
            </v-col>
        </v-row>
        </template>
        <v-data-table :items="listings" :headers="headers" hover>
            <template v-slot:item="{ item }">
                <tr>
                    <td>{{ item.title }}</td>
                    <td>{{ item.location }}</td>
                    <td>₱{{ parseInt(item.price).toLocaleString() }}</td>
                    <td>{{ item.type }}</td>
                    <td>
                        <v-chip :color="statusColor.get(item.status)">
                            {{ item.status }}
                        </v-chip>
                    </td>
                    <td>
                        <v-menu>
                            <template v-slot:activator="{ props }">
                                <v-btn icon="mdi-dots-vertical" size="small" v-bind="props"></v-btn>
                            </template>

                            <v-list>
                                <v-list-item  @click="showViewListingDialog(item)">
                                        <v-icon class="me-2">mdi-eye-outline</v-icon> View details
                                </v-list-item>
                                <v-list-item  @click="showUpdateStatusDialog(item)">
                                        <v-icon class="me-2">mdi-square-edit-outline</v-icon> Edit status
                                </v-list-item>
                                <Link :href="`/owner/edit-listing/${item.id}`">
                                    <v-list-item>
                                            <v-icon class="me-2">mdi-home-edit-outline</v-icon> Edit listing
                                    </v-list-item>
                                </Link>
                                <v-list-item  @click="showDeleteListingDialog(item)">
                                        <v-icon class="me-2" color="red">mdi-delete-empty-outline</v-icon> Delete listing
                                </v-list-item>
                            </v-list>
                        </v-menu>
                        <!-- <v-btn class="text-none text-white" size="small"  prepend-icon="mdi-square-edit-outline" color="orange"> Status</v-btn>
                        <Link :href="`/owner/edit-listing/${item.id}`">
                            <v-btn class="text-none ms-2" size="small" prepend-icon="mdi-home-edit-outline" color="blue">Edit</v-btn>
                        </Link> -->
                    </td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
        
    <v-snackbar v-model="snackbar" color="blue-lighten-3" timeout="1500">
        {{ message }}
        <template v-slot:actions>
            <v-btn variant="text" @click="snackbar = false" icon="mdi-close">
            </v-btn>
        </template>
    </v-snackbar>

    <v-dialog v-model="viewListingDialog" width="90%" style="z-index: 20;" persistent class="mt-15">
        <v-card>
            <v-card-text>
                <v-row>
                    <v-col cols="10">
                        <p class="text-h5">{{ selectedListing.title }}</p>
                    </v-col>
                    <v-col cols="2">
                        <v-btn color="red" prepend-icon="mdi-close" variant="text" block @click="viewListingDialog = false">Close Dialog</v-btn>

                    </v-col>
                </v-row>
                <MazGallery :images="listingImages" :height="300" class="mt-1" style="z-index: 50;" />
                
                <v-row class="my-4">
                    <v-col cols="8">
                        <v-list-item subtitle="Description" prepend-icon="mdi-information">
                            {{ selectedListing.description }}
                        </v-list-item>
                    </v-col>
                    <v-col cols="4">
                        <Link :href="`/profile/${auth.user.id}`">
                            <v-list-item id="owner" subtitle="Owner" :prepend-avatar="`/images/profile/${auth.user.profile_pic}`">
                                {{ auth.user.firstname + ' ' + auth.user.lastname }} 
                            </v-list-item>
                        </Link>
                    </v-col>
                    <v-divider></v-divider>
                    <v-col cols="3">
                        <v-list-item subtitle="Location" prepend-icon="mdi-map-marker">
                            {{ selectedListing.location }}
                        </v-list-item>
                    </v-col>
                    <v-col cols="2">
                        <v-list-item subtitle="Price" prepend-icon="mdi-cash">
                            {{ selectedListing.price }}
                        </v-list-item>
                    </v-col>
                    <v-col cols="7">
                        <v-list-item subtitle="Ameneties">
                            <v-chip class="ms-2 mt-2" :prepend-icon="amenity.icon" v-for="amenity in JSON.parse(selectedListing.amenities)" :key="amenity">
                                {{ amenity.title }}
                            </v-chip>
                        </v-list-item>
                    </v-col>
                    <v-col cols="5">
                        <v-list-item subtitle="Created at">
                            {{ format(new Date(selectedListing.created_at), 'PPPPp') }}
                        </v-list-item>
                    </v-col>
                    <v-col cols="7">
                        <v-row class="mt-1">
                            <v-col-6>
                                <v-list-item subtitle="Bed" prepend-icon="mdi-bed" class="text-center">
                                    {{ selectedListing.beds }}
                                </v-list-item>
                            </v-col-6>
                            <v-col-6>
                                <v-list-item subtitle="Guests" prepend-icon="mdi-account" class="text-center">
                                    {{ selectedListing.guests }}
                                </v-list-item>
                            </v-col-6>
                            <v-col-6>
                                <v-list-item subtitle="Rooms" prepend-icon="mdi-door-open" class="text-center">
                                    {{ selectedListing.rooms }}
                                </v-list-item>
                            </v-col-6>
                            <v-col-6>
                                <v-list-item subtitle="Bathrooms" prepend-icon="mdi-shower" class="text-center">
                                    {{ selectedListing.bathrooms }}
                                </v-list-item>
                            </v-col-6>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>

    <v-dialog v-model="updateStatusDialog" width="50%" persistent>
        <v-card>
            <v-card-title>
                Edit status
            </v-card-title>
            <v-card-text>
                <v-select :disabled="updateListingStatusForm.status == 'For approval'" :items="['Not available', 'Available']" v-model="updateListingStatusForm.status" label="Status"></v-select>
                <p class="ma-4  text-body-2 text-start">
                    Listing <br>
                    <strong class="text-h6">{{ updateListingStatusForm.title }}</strong>
                </p>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn @click="updateStatusDialog = false" class="text-none">Close</v-btn>
                <v-btn color="blue" variant="flat" class="text-none" @click="updateListing()" :loading="updateListingStatusForm.processing">Update status</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <!-- DELETE LISTING MODAL -->
    <v-dialog v-model="deleteListingDialog" width="auto">
        <v-card class="justify-center" width="600" title="Delete listing">
            <v-form @submit.prevent>
                <v-sheet rounded="lg" class="pa-4 text-center mx-auto">
                    <v-alert icon="mdi-alert" color="red-lighten-4" elevation="2" class="text-start text-error">
                        After you delete a listing, it's permanently deleted. Listings can't be undeleted.
                    </v-alert>
                    <p class="ma-4  text-body-2 text-start">
                        Listing <br>
                         <strong class="text-h6">{{ selectedListing.title }}</strong>
                    </p>
                    <div class="text-end">
                        <v-btn class="text-none me-4" @click="deleteListingDialog = false" variant="text" width="90">
                            Cancel
                        </v-btn>
                        <v-btn class="text-none" color="red" type="submit" @click="deleteListing"  variant="flat" width="90">
                            Delete
                        </v-btn>
                    </div>
                </v-sheet>
            </v-form>
        </v-card>
    </v-dialog>
        
</template>