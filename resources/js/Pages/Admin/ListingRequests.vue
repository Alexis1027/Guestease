<script setup>

    import {ref} from 'vue'
    import {format} from 'date-fns'
    import Layout from '../../Layouts/AdminLayout.vue'
    import ReviewListingModal from './partials/ReviewListingModal.vue'

    const entries = [5, 10, 15, 20, 25]
    const entry = ref(5)
    const page = ref(1)
    const showListingReviewModal = ref(false)
    const currentListing = ref(null)

    function showListingReviewModalFunc(listing) {
        currentListing.value = listing
        showListingReviewModal.value = true
    }

    defineProps({
        listingRequests: Object
    })
    defineOptions({
        layout: Layout
    })

</script>
<template>
    <Head title="Requests"></Head>
    <v-container class="bg-white">
        {{ showListingReviewModal }}
        <v-row justify="space-between">
            <v-col cols="2">
                    <v-select flat variant="solo-filled" v-model="entry" :items="entries" label="No. of entries"></v-select>
            </v-col>
            <v-col cols="4">
            <v-text-field label="Search..." clearable variant="solo-filled" flat :loading="false" rounded></v-text-field>
        </v-col>
        </v-row>
        <p class="text-red">doestn work rn</p>
        <v-table hover class="bg-grey-lighten-5 text-center">
            <thead >
                <tr >
                    <th class="text-center">Request id</th>
                    <th class="text-center">Owner</th>
                    <th class="text-center">Guest house</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Date Requested</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="listing in listingRequests" :key="listing.id">
                    <td>{{ listing.id }}</td>
                    <td>{{ listing.user.firstname + ' ' + listing.user.lastname }}</td>
                    <td>{{ listing.title }}</td>
                    <td> <v-chip size="small" color="orange">{{ listing.status }}</v-chip> </td>
                    <td>{{ format(new Date(listing.created_at), 'MMM dd, yyyy') }}  </td>
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
    <ReviewListingModal :show="showListingReviewModal" :listing="currentListing" @closeReviewListingModal="showListingReviewModal = false" />
</template>