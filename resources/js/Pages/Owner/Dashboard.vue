<script setup>
    
    import Layout from '../../shared/Layout.vue'
    import GuestHouseCard from './Partials/GuestHouseCard.vue'

    defineProps({
        guesthouses: Object
    })

    defineOptions({
        layout: Layout
    })

</script>

<template>

    <Head title="Owner Dashboard" />

    <v-row>
        <v-col cols="10">
            <p class="text-h4">Owner dashboard</p>
        </v-col>
        <v-col>
            <Link href="/owner/create-listing">
                <v-btn class="mt-2 text-none" prepend-icon="mdi-home-plus-outline" color="blue">Add new listing</v-btn>
            </Link>
        </v-col>
    </v-row>

    <v-row>
        <v-col cols="3" v-for="guesthouse in guesthouses" :key="guesthouse.id">
            <GuestHouseCard  :guesthouse="guesthouse" />
        </v-col>
        <v-col cols="3">
            <v-card class="mt-6 rounded-lg bg-white" height="auto" variant="outlined" color="grey">
                    <p class="font-weight-bold ms-4 mt-4 text-black">Confirm important details</p>
                    <v-list-item>
                        <template v-slot:append>
                            <v-icon size="35" color="red">mdi-alert-circle-outline</v-icon>
                        </template>
                        <p class="text-red">Required to publish</p>
                    <p class="text-grey">Guest ashouse ahouse name</p>
                    </v-list-item>
                <v-card-actions>
                    <Link href="/owner/verify-listing/1" class="ms-2 text-decoration-underline">
                        Start
                    </Link>
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row>

</template>

<style scoped>


</style>