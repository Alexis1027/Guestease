<script setup>

    import Layout from '../shared/Layout.vue'
    defineOptions({layout: Layout})
    defineProps({reservations: Object})
</script>


<template>
        <Head title="Reservations" />
        <h1>Reservations</h1>
        {{ reservations }}
</template>

