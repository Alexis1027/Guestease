<script setup>

    import {ref} from 'vue'
    import { router } from '@inertiajs/vue3';

    defineProps({ auth: Object })
    const sidebar = ref(true)
    const logo = '/images/logo/frlogo-transformed.png'

    const logout = () => {
         router.post('/logout', {}, {
            onSuccess: () => {
                window.history.replaceState({}, document.title, '/')
                window.location.replace('/')
                sessionStorage.clear()
            }
        })
    }

</script>

<template>
    <v-layout>
        <v-navigation-drawer style="z-index: 10;" v-model="sidebar" expand-on-hover :permanent="true" location="left" temporary rail>
            
            <v-list-item class="ma-0" height="69">
                <template v-slot:prepend>
                    <v-avatar rounded="0">
                        <v-img src="/images/logo/small.png"></v-img>
                    </v-avatar>
                </template>
                <v-img src="/images/logo/text.png"></v-img>
            </v-list-item>

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
                    </v-list-item>
                </Link>
                <Link href="/admin/create-admin">
                    <v-list-item prepend-icon="mdi-account-hard-hat" title="Create admin account" value="createadmin"></v-list-item>
                </Link>
                <Link href="/admin/reported-guests">
                    <v-list-item prepend-icon="mdi-flag" title="Reported guests" value="reports"></v-list-item>
                </Link>
                <Link href="/admin/contact-form-submissions">
                    <v-list-item prepend-icon="mdi-email-open-multiple" title="Contact us submissions" value="contact"></v-list-item>
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
                                <v-tooltip text="Logout" location="top">
                                    <template v-slot:activator="{ props }">
                                        <Link @click="logout" method="post" class="me-6">
                                            <v-btn v-bind="props" icon="mdi-logout" color="red" variant="text"></v-btn>
                                        </Link>
                                    </template>
                                </v-tooltip>
                            </template>
                        </v-list-item>
                    </div>
                </template>

        </v-navigation-drawer>

        <v-main class="bg-grey-lighten-3" style="height: 100vh;">
            <slot>
            </slot>
        </v-main>

    </v-layout>

</template>