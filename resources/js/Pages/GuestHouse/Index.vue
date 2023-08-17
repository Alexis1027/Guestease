<script setup>

    import GuestHouseCard from '../../components/GuestHouseCard.vue';
    import Layout from '../../shared/Layout.vue';
    import {defineProps} from 'vue'
    defineOptions({layout: Layout})

    const guesthouses = defineProps(['guesthouses'])
</script>


<template>
        <Head title="Home" />
        <div class="sticky-btn-container">
      <Link href="/map">
        <v-btn class="bg-blue" prepend-icon="mdi-map">SHOW MAP</v-btn>
      </Link>
    </div>
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