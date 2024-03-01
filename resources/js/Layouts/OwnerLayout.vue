<script setup>

    import {router} from '@inertiajs/vue3'

    const logo = '/images/logo/frlogo-transformed.png'
    function logout() {
        router.post('/logout')
    }
    defineProps({ auth: Object })
</script>
<template>
    
    <v-layout>
        <v-app-bar scroll-threshold="438">
            <v-toolbar-title>
                <Link class="font-weight-bold">
                    <v-img :src="logo" height="55" width="260" cover></v-img>
                </Link>
            </v-toolbar-title>
            <v-divider vertical />
            
                <Link href="/owner/dashboard">
                    <v-btn class="text-none rounded-pill ms-2" :color="$page.component == 'Owner/Dashboard' ? 'blue' : ''">
                        Dashboard
                    </v-btn>
                </Link>
                <Link href="/owner/listings">
                    <v-btn class="text-none rounded-pill" :color="$page.component == 'Owner/Listings' ? 'blue' : ''">
                        Listings
                    </v-btn>
                </Link>
                <Link href="/owner/reservations">
                    <v-btn class="text-none rounded-pill" :color="$page.component == 'Owner/Reservations' ? 'blue' : ''">
                        Reservations
                    </v-btn>
                </Link>
            
            <v-spacer/>
            <v-spacer/>
            <!-- <v-menu min-width="200px" rounded v-if="auth">
                <template v-slot:activator="{ props }">
                    <v-btn icon="mdi-bell-ring-outline" size="large" v-bind="props">
                    </v-btn>
                </template>
                <v-card width="500">
                    <div class="mx-auto text-start my-2">
                        <v-list-item>
                            <p class="text-h6">Notifications</p>
                        </v-list-item>
                        <v-divider class="mt-2" />
                        <v-list class="mb-2">
                            <v-list-item v-for="n in 4" :key="n"  :value="n" :subtitle="`${n+1} days ago`" prepend-avatar="https://static1.cbrimages.com/wordpress/wp-content/uploads/2022/04/Nacho-Varga---Better-Call-Saul.jpg" value="profile">
                                <template v-slot:append>
                                    <v-btn icon="mdi-trash-can-outline" color="red" variant="text"></v-btn>
                                </template>
                                <template v-slot:title>
                                    Nacho varga reserved at your place.
                                </template>
                            </v-list-item>
                        </v-list>
                    </div>
                </v-card>
            </v-menu> -->
            <v-menu min-width="200px" rounded v-if="auth">
                <template v-slot:activator="{ props }">
                    <v-btn icon size="large" v-bind="props">
                        <v-avatar color="blue-lighten-3" size="40">
                            <v-img :src="`/images/profile/${auth.user.profile_pic}`"></v-img>
                        </v-avatar>
                    </v-btn>
                </template>
                <v-card width="235">
                    <div class="mx-auto text-start">
                        <v-list>
                            <v-list-item
                                :prepend-avatar="`/images/profile/${auth.user.profile_pic}`"
                                :title="auth.user.firstname + ' ' + auth.user.lastname"
                                subtitle="owner"
                                >
                                </v-list-item>
                            <v-divider class="my-2" />
                            <Link :href="`/profile/${auth.user.id}`">
                                <v-list-item prepend-icon="mdi-account-outline" value="profile">
                                    Profile
                                </v-list-item>
                            </Link>
                            <Link href="/account">
                                <v-list-item prepend-icon="mdi-account-edit-outline" value="account">
                                    Account
                                </v-list-item>
                            </Link>
                            <Link @click="logout" method="post">
                                <v-list-item prepend-icon="mdi-logout" value="logout" color="red" class="text-red">
                                    Logout
                                </v-list-item>
                            </Link>
                        </v-list>
                    </div>
                </v-card>
            </v-menu>
        </v-app-bar>
        <v-main class="bg-grey-lighten-3">
            <slot>
            </slot>
        </v-main>
    </v-layout>
</template>