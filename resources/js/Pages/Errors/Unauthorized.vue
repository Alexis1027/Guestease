<script setup>

    defineProps({ auth: Object })
    const links = new Map([
        ['owner', '/owner/dashboard'],
        ['admin', '/admin/dashboard'],
        ['guest', '/'],
    ])

</script>

<template>
    <v-container class="text-center mt-10">
        <p class="text-h1 text-red">403</p>
        <p class="text-h2">FORBIDDEN</p>
        <p class="mt-2 text-h5">We are sorry, but you do not have access to this page or resource.</p>
        <Link :href="links.get(auth.user.role)">
            <v-btn class="mt-4" color="blue">Back to homepage</v-btn>
        </Link>
    </v-container>
</template>