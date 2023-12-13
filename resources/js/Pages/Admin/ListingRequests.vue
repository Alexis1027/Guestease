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
    <v-container>
        <v-card>
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
        </v-card>
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