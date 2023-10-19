<script setup>
    
    import OwnerLayout from '../../Layouts/OwnerLayout.vue'
    import GuestHouseCard from './Partials/GuestHouseCard.vue'

    defineProps({
        listings: Object,
        auth: Object
    })

    defineOptions({
        layout: OwnerLayout
    })

</script>

<template>

    <v-row class="mt-6">
        <v-col cols="9">
            <p class="text-h4">Welcome, {{ auth.user.firstname }}!</p>
            Guests can reserve after the administrator publishes your place.
        </v-col>
        <v-col class="justify-end d-flex">
            <Link href="/owner/create-listing">
                <v-btn class="mt-2 text-none" variant="outlined" prepend-icon="mdi-plus" color="blue">Create new listing</v-btn>
            </Link>
        </v-col>
    </v-row>

    <v-row>
        <v-col cols="3" v-for="listing in listings" :key="listing.id">
            <GuestHouseCard  :listing="listing" />
        </v-col>
        <v-col cols="3">
            <v-card class="mt-6 rounded-lg bg-white" height="auto" variant="outlined" color="grey" v-if="listings.length <= 0">
                    <p class="font-weight-bold ms-4 mt-4 text-black">Create new listing</p>
                    <v-list-item>
                        <template v-slot:append>
                            <v-icon size="35" color="green">mdi-plus</v-icon>
                        </template>
                    <p class="text-grey">Lorem ipsum dolor sit amet.</p>
                    </v-list-item>
                <v-card-actions>
                    <Link href="/owner/create-listing" class="ms-2 text-decoration-underline">
                        Start
                    </Link>
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row>

</template>

<style scoped>


</style>