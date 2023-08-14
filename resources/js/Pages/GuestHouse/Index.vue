<script setup>

    import GuestHouseCard from '../../components/GuestHouseCard.vue';
    import Layout from '../../shared/Layout.vue';
    import {defineProps} from 'vue'
    defineOptions({layout: Layout})

    const guesthouses = defineProps(['guesthouses'])
    
    console.log(guesthouses)
</script>


<template>
    <v-container>
        <!-- {{ guesthouses.guesthouses }} -->
        <v-row>
            <v-col cols="3" v-for="guesthouse in guesthouses.guesthouses" :key="guesthouse.id">
                <GuestHouseCard :guesthouse="guesthouse" />
            </v-col>
        </v-row>
    </v-container>
</template>