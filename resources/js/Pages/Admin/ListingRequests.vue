<script setup>

    import {ref} from 'vue'
    import {format} from 'date-fns'
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

    defineProps({
        listingRequests: Object
    })
    defineOptions({
        layout: AdminLayout
    })
</script>
<template>
    <Head title="Listing requests"></Head>
    <v-container class="bg-white">
        <v-row justify="space-between">
            <v-col cols="2">
                    <v-select flat variant="solo-filled" v-model="entry" :items="entries" label="No. of entries"></v-select>
            </v-col>
            <v-col cols="4">
            <v-text-field label="Search..." clearable variant="solo-filled" flat :loading="false" rounded></v-text-field>
        </v-col>
        </v-row>
        <v-table hover class="bg-grey-lighten-5 text-center">
            <thead >
                <tr >
                    <th class="text-center">ID</th>
                    <th class="text-center">Owner</th>
                    <th class="text-center">Listing</th>
                    <th class="text-center">Date Requested</th>
                    <th class="text-center">
                        <v-menu open-on-hover>
                            <template v-slot:activator="{ props }">
                                <v-btn variant="text" append-icon="mdi-menu-down" class="text-none" v-bind="props">
                                    Status
                                </v-btn>
                            </template>

                            <v-list>
                                <p class="text-red">dont work rn</p>
                                <v-list-item value="for approval">
                                    For Approval
                                </v-list-item>
                                <v-list-item value="declined">
                                    Declined
                                </v-list-item>
                                <v-list-item value="approved">
                                    Approved
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <v-slide-x-transition class="py-0" group>
                    <tr v-for="listing in listingRequests" :key="listing.id">
                        <td>{{ listing.id }}</td>
                        <td>{{ listing.user.firstname + ' ' + listing.user.lastname }}</td>
                        <td>{{ listing.title }}</td>
                        <td>{{ format(new Date(listing.created_at), 'MMM dd, yyyy') }}  </td>
                        <td> <v-chip size="small" color="orange">{{ listing.status }}</v-chip> </td>
                        <td>
                            <v-btn prepend-icon="mdi-file-find" @click="showListingReviewModalFunc(listing)" size="small" class="text-green text-none bg-grey-lighten-5" variant="tonal">Review</v-btn>
                            <v-btn size="small" class="text-red bg-grey-lighten-5 text-none ms-1" variant="tonal"> 
                                <v-icon>mdi-delete-outline</v-icon> Delete
                            </v-btn>
                            <!-- <v-btn icon="mdi-close" size="small" class="text-blue" flat></v-btn> -->
                            <!-- <v-btn icon="mdi-check" size="small" class="text-green" flat></v-btn> -->
                        </td>
                    </tr>
                    <tr v-if="listingRequests.length <= 0">
                        <td colspan="8"> No requests.</td>
                    </tr>
                </v-slide-x-transition>
            </tbody>
        </v-table>
        <v-row  class="mt-2">
            <v-col class="d-flex justify-end">
                <v-pagination v-model="page" :length="10" :total-visible="4" rounded="circle">
                </v-pagination>
            </v-col>
        </v-row>
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