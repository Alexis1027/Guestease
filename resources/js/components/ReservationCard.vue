<script setup>

    defineProps({reservation: Object})

</script>

<template>
    <v-card class="mt-3">
        {{ reservation }}
    </v-card>
</template>