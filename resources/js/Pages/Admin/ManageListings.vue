<script setup>

    defineOptions({ layout: AdminLayout })
    defineProps({ listings: Object, newEntry: Object })
    import {ref, defineProps, watch} from 'vue'
    import {router, useForm} from '@inertiajs/vue3'
    import AdminLayout from '../../Layouts/AdminLayout.vue'
    import DeleteListingDialog from './partials/DeleteListingDialog.vue'
    import {format} from 'date-fns'
    import MazGallery from 'maz-ui/components/MazGallery'

    const deleteListingDialog = ref(false)
    const deleteSnackbar = ref(false)
    const updateSnackbar = ref(false)
    const listing = ref({})
    const viewListingDialog = ref(false)
    const updateStatusDialog = ref(false)
    const listingImages = ref(null)
    const selectedListing = ref(null)

    const updateListingStatusForm = useForm({
        id: null,
        status: null,
        title: null
    })

    function deleteListing(gh) {
        listing.value = gh
        deleteListingDialog.value = true
    }

    function updateListing() {
        updateListingStatusForm.put(`/admin/update-listing/${updateListingStatusForm.id}`, {
            onSuccess: () => {
                updateSnackbar.value = true
                updateStatusDialog.value = false
            }
        })
        // router.put(`/admin/update-listing/${listing.id}`, {status}, {
        //     onSuccess:() => {
        //         updateSnackbar.value = true
        //     }
        // })
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

    const headers = [
        { title: 'ID', align: 'start', sortable: false, key: 'id', value: "id" },
        { title: 'Title', align: 'start', key: 'title', value: "title" },
        { title: 'Location', align: 'start', key: 'location', value: "location" },
        { title: 'Price', align: 'start', key: 'price', value: "price" },
        { title: 'Type', align: 'start', key: 'type', value: "type" },
        { title: 'Status', align: 'start', key: 'status', value: "status" },
        { title: 'Actions', align: 'start', key: 'actions', value: "actions" },
    ]

</script>


<template>
    <Head title="Manage Listings" />
    <v-container>
        <v-data-table :items="listings" :headers="headers">
            <template v-slot:item="{ item }">
                <tr>
                    <td>{{ item.id }}</td>
                    <td>{{ item.title }}</td>
                    <td>{{ item.location }}</td>
                    <td>{{ item.price }}</td>
                    <td>{{ item.type }}</td>
                    <td>{{ item.status }}</td>
                    <td>
                        <v-btn prepend-icon="mdi-eye-outline" @click="showViewListingDialog(item)" size="small" color="green" class="text-none me-2">View</v-btn>
                        <v-btn class="text-none" size="small" @click="showUpdateStatusDialog(item)" prepend-icon="mdi-square-edit-outline" color="blue">Update</v-btn>
                    </td>
                </tr>
            </template>
        </v-data-table>
    </v-container>

    <!-- <DeleteListingDialog :listing="listing" @showDeleteSuccessfulSnackbar="deleteSnackbar = true" :show="deleteListingDialog" @CloseDialog="deleteListingDialog = false" v-model="deleteListingDialog" /> -->

    <!-- <v-snackbar v-model="deleteSnackbar" color="red-lighten-3" timeout="1500" >
        Deleted successfully
        <template v-slot:actions>
            <v-btn variant="text" @click="deleteSnackbar = false" icon="mdi-close">
            </v-btn>
        </template>
    </v-snackbar> -->

    <v-snackbar v-model="updateSnackbar" color="blue-lighten-3" timeout="1500">
        Updated successfully
        <template v-slot:actions>
            <v-btn variant="text" @click="updateSnackbar = false" icon="mdi-close">
            </v-btn>
        </template>
    </v-snackbar>

    <v-dialog v-model="viewListingDialog" width="90%" z-index="50" persistent class="mt-15">
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
                <MazGallery :images="listingImages" :height="300" class="mt-1" />
                
                <v-row class="mt-2">
                    <v-col cols="8">
                        <v-list-item subtitle="Description" prepend-icon="mdi-information">
                            {{ selectedListing.description }}
                        </v-list-item>
                    </v-col>
                    <v-col cols="4">
                        <Link :href="`/profile/${selectedListing.owner.id}`">
                            <v-list-item id="owner" subtitle="Owner" :prepend-avatar="`/images/profile/${selectedListing.owner.profile_pic}`">
                                {{ selectedListing.owner.firstname + ' ' + selectedListing.owner.lastname }} 
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
                Edit <strong>{{ updateListingStatusForm.title }}</strong>'s status
            </v-card-title>
            <v-card-text>
                <v-select :items="['Not available', 'Available']" v-model="updateListingStatusForm.status" label="Status"></v-select>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn @click="updateStatusDialog = false">Close</v-btn>
                <v-btn color="blue"  @click="updateListing()" :loading="updateListingStatusForm.processing">Update</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

</template>

<style scoped>

    .v-table, th, td {
        border: 1px solid rgb(238,238,238);
    }

    #owner:hover {
        text-decoration: underline;
    }

</style>
