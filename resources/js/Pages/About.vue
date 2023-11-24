<script setup>

    import GuestLayout from '../Layouts/GuestLayout.vue'
    defineOptions({layout: GuestLayout})
    defineProps({
        listing: Object
    })

</script>

<template>
    <Head title="About" />
    <h1>About page</h1>
    {{ listing }}
    sadasdsa
</template>

