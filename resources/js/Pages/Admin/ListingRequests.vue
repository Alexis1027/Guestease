<script setup>

    defineProps({ listingRequests: Object })
    defineOptions({ layout: AdminLayout })
    import {ref, watch} from 'vue'
    import {format} from 'date-fns'
    import {router} from '@inertiajs/vue3'
    import AdminLayout from '../../Layouts/AdminLayout.vue'
    import ReviewListingModal from './partials/ReviewListingModal.vue'

    const entries = [5, 10, 15, 20, 25]
    const entry = ref(5)
    const page = ref(1)
    const showListingReviewModal = ref(false)
    const currentListing = ref(null)
    const snackbar = ref(false)

    function showListingReviewModalFunc(listing) {
        currentListing.value = listing
        showListingReviewModal.value = true
    }

    watch(entry, () => {
        router.get(`/admin/listing-requests/${entry.value}`)
    })

    const headers = [
        { title: 'ID', align: 'start', key: 'id', value: "id" },
        { title: 'Owner', align: 'start', key: 'title', value: "title" },
        { title: 'Listing', align: 'start', key: 'location', value: "location" },
        { title: 'Date requested', align: 'start', key: 'price', value: "price" },
        { title: 'Status', align: 'start', key: 'type', value: "type" },
        { title: 'Actions', align: 'start', key: 'actions', value: "actions" },
    ]

</script>
<template>
    <Head title="Listing requests"></Head>
    <v-container class="bg-white">
        <v-data-table :items="listingRequests" :headers="headers">
            <template v-slot:item="{ item }">
                <tr>
                    <td>{{ item.id }}</td>
                    <td>{{ item.user.firstname + " " + item.user.lastname }}</td>
                    <td>{{ item.title }}</td>
                    <td>{{ format(new Date(item.created_at), 'MMM dd, yyyy') }}</td>
                    <td>
                        <v-chip size="small" color="orange">{{ item.status }}</v-chip>
                    </td>
                    <td>
                        <v-btn prepend-icon="mdi-file-find" @click="showListingReviewModalFunc(item)" size="small" class="text-green text-none bg-grey-lighten-5" variant="tonal">Review</v-btn>
                    </td>
                </tr>
            </template>
        </v-data-table>
        <!-- <v-table hover class="bg-grey-lighten-5 text-center">
            <thead >
                <tr >
                    <th class="text-center">ID</th>
                    <th class="text-center">Owner</th>
                    <th class="text-center">Listing</th>
                    <th class="text-center">Date Requested</th>
                    <th class="text-center"> Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <v-slide-x-transition class="py-0" group>
                    <tr v-for="listing in listingRequests.data" :key="listing.id">
                        <td>{{ listing.id }}</td>
                        <td>{{ listing.user.firstname + ' ' + listing.user.lastname }}</td>
                        <td>{{ listing.title }}</td>
                        <td>{{ format(new Date(listing.created_at), 'MMM dd, yyyy') }}  </td>
                        <td> <v-chip size="small" color="orange">{{ listing.status }}</v-chip> </td>
                        <td>
                            <v-btn prepend-icon="mdi-file-find" @click="showListingReviewModalFunc(listing)" size="small" class="text-green text-none bg-grey-lighten-5" variant="tonal">Review</v-btn>
                        </td>
                    </tr>
                    <tr v-if="listingRequests.data.length <= 0">
                        <td colspan="8"> No requests.</td>
                    </tr>
                </v-slide-x-transition>
            </tbody>
        </v-table> -->
        <!-- <v-row  class="mt-2">
            <v-col class="d-flex justify-end">
                <v-pagination v-model="page" :length="10" :total-visible="4" rounded="circle">
                </v-pagination>
            </v-col>
        </v-row> -->
        <!-- <v-row  class="mt-2">
        <v-col class="d-flex justify-end">
            <Link 
                v-for="link in listingRequests.links" 
                :class="{ 'font-weight-bold' : link.active, 'mx-3' : link.url }" 
                :key="link" 
                :href="link.url"
                v-html="link.label"
                >
            </Link>
        </v-col>
    </v-row> -->
    </v-container>
    <ReviewListingModal :show="showListingReviewModal" @approved="snackbar = true" :listing="currentListing" v-if="showListingReviewModal" @closeReviewListingModal="showListingReviewModal = false" />
    <v-snackbar v-model="snackbar">
        Listing approved 
        <template v-slot:actions>
            <v-btn color="blue" variant="text" @click="snackbar = false">
                Close
            </v-btn>
        </template>
    </v-snackbar>
</template>