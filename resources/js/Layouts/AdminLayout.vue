<script setup>

    import {ref} from 'vue'

    const sidebar = ref(false)
    const logo = '/images/logo/frlogo-transformed.png'

    defineProps({
        auth: Object
    })

</script>

<template>
    <v-layout>
        <v-app-bar>
            <v-app-bar-nav-icon @click="sidebar = !sidebar"></v-app-bar-nav-icon>
        
        <v-toolbar-title>
            <Link class="font-weight-bold">
                <v-img :src="logo" height="55" width="260" cover></v-img>
            </Link>
        </v-toolbar-title>
        <v-spacer/>
        <v-menu min-width="200px" rounded>
            <template v-slot:activator="{ props }">
                <v-btn class="text-none" icon v-bind="props" >
                    <v-badge content="2" color="error">
                        <v-icon>mdi-bell-outline</v-icon>
                    </v-badge>
                </v-btn>
            </template>
            <v-card width="450" >
                <v-list>
                    <p class="text-red"> dont work rn</p>
                    <v-list-item value="1">
                        John Doe requested to create a room.
                    </v-list-item>
                    <v-list-item :value="n" v-for="n in 6" :key="n">
                        Firstname Lastname requested to create a room.
                    </v-list-item>
                    <v-divider/>
                    <Link href="/requests">
                        <v-list-item value="see all" class="text-center">
                            See all
                        </v-list-item>
                    </Link>
                </v-list>
            </v-card>
        </v-menu>
        <Link href="/logout" method="post" class="me-6">
            <v-btn color="red">Logout</v-btn>
        </Link>
        </v-app-bar>
        <v-navigation-drawer v-model="sidebar" :permanent="true" location="left" temporary>
            <v-list>
                <v-list-item
                :prepend-avatar="`/images/profile/${auth.user.profile_pic}`" :title="`${auth.user.firstname} ${auth.user.lastname}`" subtitle="admin"
                ></v-list-item>
            </v-list>
            <v-divider></v-divider>
            <v-list density="compact" nav >
                <Link href="/admin/dashboard">
                    <v-list-item prepend-icon="mdi-view-dashboard" title="Dashboard" value="dashboard"></v-list-item>
                </Link>
                <Link href="/admin/manage-guesthouses">
                    <v-list-item prepend-icon="mdi-home-edit" title="Guest house management" value="manageguesthouse"></v-list-item>
                </Link>
                <Link href="/admin/manage-users">
                    <v-list-item prepend-icon="mdi-account-edit" title="User management" value="manageuser"></v-list-item>
                </Link>
                <Link href="/admin/manage-reservations">
                    <v-list-item prepend-icon="mdi-calendar-edit" title="Reservation management" value="managereservation"></v-list-item>
                </Link>
                <Link href="/admin/listing-requests">
                    <v-list-item prepend-icon="mdi-help-box-multiple" title="Listing requests" value="requests"></v-list-item>
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
            <v-container>   
                <slot>
                </slot>
            </v-container>
        </v-main>
    </v-layout>

</template>