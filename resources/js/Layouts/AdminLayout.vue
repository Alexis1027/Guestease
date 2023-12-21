<script setup>

    import {ref} from 'vue'
    import { router } from '@inertiajs/vue3';
    // import { useInertia } from '@inertiajs/inertia-vue3';

    const inertia = useInertia()
    const sidebar = ref(true)
    const logo = '/images/logo/frlogo-transformed.png'

    function logout() {
        router.post('/logout', [], {
            onSuccess: () => {
                location.href = '/'
                window.history.replaceState({}, document.title, '/')
            }
        })
    }

    // const logout = async () => {
    //     await inertia.post('/logout');
    //     window.location.replace('/');
    // }

    defineProps({
        auth: Object
    })

</script>

<template>
    <v-layout>
        <v-navigation-drawer style="z-index: 10;" v-model="sidebar" :permanent="true" location="left" temporary>
            <v-sheet class="pa-2 border-0">
                <v-img :src="logo" height="50" width="260" cover></v-img>
                <!-- <v-list-item
                :prepend-avatar="`/images/profile/${auth.user.profile_pic}`" 
                :title="`${auth.user.firstname} ${auth.user.lastname}`" 
                subtitle="Admin"
                >
            </v-list-item> -->
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
                <Link href="/admin/reported-guests">
                    <v-list-item prepend-icon="mdi-account-alert" title="Reported guests" value="reports"></v-list-item>
                </Link>
                
            </v-list>
            
                <template v-slot:append>
                    <div class="ma-1">
                        <v-list-item
                        :prepend-avatar="`/images/profile/${auth.user.profile_pic}`" 
                        :title="`${auth.user.firstname} ${auth.user.lastname}`" 
                        subtitle="Admin"
                        >
                            <template v-slot:append>
                                <Link @click="logout" method="post" class="me-6">
                                    <v-btn icon="mdi-logout" color="red" variant="text"></v-btn>
                                </Link>
                            </template>
                        </v-list-item>
                    </div>
                </template>
        </v-navigation-drawer>
        <v-main class="bg-grey-lighten-3" style="height: 100vh;">
            <!-- <v-app-bar>
                <v-app-bar-nav-icon @click="sidebar = !sidebar"></v-app-bar-nav-icon>
                <v-toolbar-title>
                    <Link class="font-weight-bold" href="/admin/dashboard" >
                        <v-img :src="logo" height="55" width="260" cover></v-img>
                    </Link>
                </v-toolbar-title>
                <v-spacer/>
                <Link @click="logout" method="post" as="button" class="me-6">
                    <v-btn color="red">Logout</v-btn>
                </Link>
            </v-app-bar> -->
                <slot>
                </slot>
        </v-main>
    </v-layout>

</template>