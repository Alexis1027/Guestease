<script setup>

    import Layout from '../shared/Layout.vue'
    defineOptions({layout: Layout})

    import { useDate } from 'vuetify/labs/date'

    const date = useDate()

const formatted = date.format(new Date(), 'keyboardDate')

console.log(formatted)

</script>




<template>
    <Head title="About" />
       
    <h1>About page</h1>
</template>

