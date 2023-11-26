<script setup>

    import {ref} from 'vue'
    import { router } from '@inertiajs/vue3';

    const sidebar = ref(false)
    const logo = '/images/logo/frlogo-transformed.png'

    function logout() {
        router.post('/logout', [], {
            onSuccess: () => {
                location.href = '/'
                window.history.replaceState({}, document.title, '/')
            }
        })
        
    }

    defineProps({
        auth: Object
    })

</script>

<template>
    <v-layout>
        <v-navigation-drawer v-model="sidebar" :permanent="true" location="left" temporary>
            <v-sheet class="pa-2 border-0">
                <v-list-item
                :prepend-avatar="`/images/profile/${auth.user.profile_pic}`" 
                :title="`${auth.user.firstname} ${auth.user.lastname}`" 
                subtitle="Admin"
                >
            </v-list-item>
            </v-sheet>
            <v-divider></v-divider>
            <v-list density="compact" nav>
                <Link href="/admin/dashboard">
                    <v-list-item prepend-icon="mdi-view-dashboard" title="Dashboard" value="dashboard"></v-list-item>
                </Link>
                <Link href="/admin/manage-listings">
                    <v-list-item prepend-icon="mdi-home" title="Listing management" value="managelistings"></v-list-item>
                </Link>
                <Link href="/admin/manage-users">
                    <v-list-item prepend-icon="mdi-account" title="User management" value="manageuser"></v-list-item>
                </Link>
                <Link href="/admin/manage-reservations">
                    <v-list-item prepend-icon="mdi-calendar" title="Reservation management" value="managereservation">
                    </v-list-item>
                </Link>
                <Link href="/admin/listing-requests">
                    <v-list-item prepend-icon="mdi-help-box-multiple" title="Listing requests" value="requests">
                        <!-- <template v-slot:append>
                            <v-chip color="red">21</v-chip>
                        </template> -->
                    </v-list-item>
                </Link>
                <Link href="/admin/create-admin">
                    <v-list-item prepend-icon="mdi-account-hard-hat" title="Create admin account" value="createadmin"></v-list-item>
                </Link>
                <Link href="/rules">
                    <v-list-item prepend-icon="mdi-playlist-check" title="Rules and regulations" value="rules"></v-list-item>
                </Link>
            </v-list>
        </v-navigation-drawer>
        <v-main>
            <v-app-bar>
                <v-app-bar-nav-icon @click="sidebar = !sidebar"></v-app-bar-nav-icon>
                <v-toolbar-title>
                    <Link class="font-weight-bold" href="/admin/dashboard" >
                        <v-img :src="logo" height="55" width="260" cover></v-img>
                    </Link>
                </v-toolbar-title>
                <v-spacer/>
                <!-- <v-menu min-width="200px" rounded>
                    <template v-slot:activator="{ props }">
                        <v-btn class="text-none" icon v-bind="props" >
                            <v-badge content="6" color="error">
                                <v-icon>mdi-bell-outline</v-icon>
                            </v-badge>
                        </v-btn>
                    </template>
                    <v-card width="450">
                        <v-toolbar>
                            <v-toolbar-title>Notifications</v-toolbar-title>
                            
                            <v-spacer/>
                            <v-btn icon>
                                <v-icon>mdi-magnify</v-icon>
                            </v-btn>
                            <v-btn icon>
                                <v-icon>mdi-dots-vertical</v-icon>
                            </v-btn>
                        </v-toolbar>
                        <v-list>
                            <p class="text-red ms-5">doestn work</p>
                            <v-list-item 
                                :value="n" 
                                v-for="n in 6" 
                                :key="n"
                                class="py-2"
                                prepend-avatar="../images/profile/21.png" 
                                title="John Doe has a pending listing."
                                :subtitle="`${n+1} hours ago`">
                            </v-list-item>
                            <v-divider/>
                            <Link href="/admin/listing-requests">
                                <v-list-item value="see all" class="text-center">
                                    See all
                                </v-list-item>
                            </Link>
                        </v-list>
                    </v-card>
                </v-menu> -->
                <Link @click="logout" method="post" as="button" class="me-6">
                    <v-btn color="red">Logout</v-btn>
                </Link>
            </v-app-bar>
                <slot>
                </slot>
        </v-main>
    </v-layout>

</template>