<script setup>

    import GuestHouseCard from '../../components/GuestHouseCard.vue';
    import Layout from '../../shared/Layout.vue';
    import {defineProps} from 'vue'
    defineOptions({layout: Layout})

    const guesthouses = defineProps(['guesthouses'])
    
    console.log(guesthouses)
</script>


<template>
        <Head title="Home" />
        <Link href="/map">
            <div>
                <v-btn class="bg-blue" prepend-icon="mdi-map"> SHOW MAP</v-btn>
            </div>
        </Link>
        <!-- {{ guesthouses.guesthouses }} -->
        <v-row>
            <v-col cols="3" v-for="guesthouse in guesthouses.guesthouses" :key="guesthouse.id">
                <GuestHouseCard :guesthouse="guesthouse" />
            </v-col>
        </v-row>
</template>

<style scoped>

    .v-btn {
        position: absolute;
        z-index: 9;
        bottom: 0;
        right: 0;
        margin-bottom: 40px;
        margin-right: 50px;
    }

</style>