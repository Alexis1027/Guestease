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
            <p class="text-h4">Owner dashboard or Guest house listings</p>
        </v-col>
        <v-col>
            <v-btn class="mt-2 text-none" color="blue">Create new </v-btn>
        </v-col>
    </v-row>

    <v-row>
        <v-col cols="3"  v-for="guesthouse in guesthouses" :key="guesthouse.id">
            <GuestHouseCard  :guesthouse="guesthouse" />
        </v-col>
    </v-row>

</template>