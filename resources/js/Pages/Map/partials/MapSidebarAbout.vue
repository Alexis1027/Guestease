<script setup>

    import {defineProps} from 'vue'
    const p = defineProps(['about'])

</script>
<template>
    <div>
        <h2>About this place</h2>
        <p>{{ p.about }}</p>
</div>
</template>