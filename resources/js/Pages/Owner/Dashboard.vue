<script setup>
    
    import OwnerLayout from '../../Layouts/OwnerLayout.vue'
    import ListingCard from './Partials/ListingCard.vue'

    defineProps({
        listings: Object,
        auth: Object,
        total_listings: Number,
        pending_listings: Number,
        approved_listings: Number,
        total_reservations: Number,
        pending_reservations: Number,
    })

    defineOptions({
        layout: OwnerLayout
    })

</script>

<template>
    <Head title="Dashboard"/>
    <v-container>
        <v-row >
            <v-col cols="9">
                <p class="text-h4 text-capitalize">Welcome, {{ auth.user.firstname }}!</p>
                Guests can reserve after the administrator publishes your listing.
            </v-col>
        </v-row>

        <v-row>
            
            <v-col cols="12" lg="3" md="3" sm="6" xl="3">
                <v-alert border="start" title="Total listings" class="bg-white" border-color="blue" elevation="2">
                    {{ total_listings }}
                </v-alert>
            </v-col>
            <v-col cols="12" lg="3" md="3" sm="6" xl="3">
                <v-alert border="start" title="Pending listings" class="bg-white" border-color="blue" elevation="2">
                    {{ pending_listings }}
                </v-alert>
            </v-col>
            <v-col cols="12" lg="3" md="3" sm="6" xl="3">
                <v-alert border="start" title="Approved listings" class="bg-white" border-color="blue" elevation="2">
                    {{ approved_listings }}
                </v-alert>
            </v-col>
            <v-col cols="12" lg="3" md="3" sm="6" xl="3">
                <v-alert border="start" title="Total reservations" class="bg-white" border-color="blue" elevation="2">
                    {{ total_reservations }}
                </v-alert>
            </v-col>
            <v-col cols="12" lg="3" md="3" sm="6" xl="3">
                <v-alert border="start" title="Pending reservations" class="bg-white" border-color="blue" elevation="2">
                    {{ pending_reservations }}
                </v-alert>
            </v-col>
            <!-- <v-col cols="12" lg="3" md="3" sm="6" xl="3">
                <v-alert border="start" title="Upcoming reservations" class="bg-white" border-color="blue" elevation="2">
                    n
                </v-alert>
            </v-col> -->
        </v-row>

        <v-row>
            <v-col cols="12" lg="3" md="4" sm="6" xl="3" v-for="listing in listings" :key="listing.id">
                <ListingCard  :listing="listing" />
            </v-col>
            <v-col cols="12" lg="3" md="3" sm="6" xl="3">
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
    </v-container>

</template>

<style scoped>


</style>