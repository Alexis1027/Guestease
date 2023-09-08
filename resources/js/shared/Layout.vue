<script setup>

    import {ref, defineProps} from 'vue'
    import {useForm} from '@inertiajs/vue3'

    const sidebar = ref(false)
    const {auth} = defineProps(['auth'])
    const form = useForm({
        user_id: auth ? auth.user.id : null
    })
    function request() {
        form.post('/request')
    }
</script>

<template>
    <v-layout class="bg-grey-lighten-3">
        <v-app-bar scroll-behavior="elevate" scroll-threshold="438">
            <v-app-bar-nav-icon @click="sidebar = !sidebar" v-if="auth && auth.user.role == 'admin'"></v-app-bar-nav-icon>
            <v-toolbar-title>
                <Link href="/">
                    Logo 
                </Link>
            </v-toolbar-title>
            <!-- <v-text-field label="Search..." clearable flat rounded prepend-inner-icon="mdi-magnify" v-model="search" variant="outlined" color="blue">
            </v-text-field> -->
            <v-spacer/>
            <v-menu min-width="200px" rounded v-if="auth && auth.user.role == 'admin'">
                <template v-slot:activator="{ props }">
                    <v-btn class="text-none" icon v-bind="props" >
                        <v-badge content="2" color="error">
                            <v-icon>mdi-bell-outline</v-icon>
                        </v-badge>
                    </v-btn>
                </template>
                <v-card width="450" >
                    <v-list>
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
            <v-menu min-width="200px" rounded >
                <template v-slot:activator="{ props }">
                    <v-btn icon v-bind="props">
                        <v-avatar color="blue-lighten-3" size="35">
                            <v-icon>mdi-account</v-icon>
                        </v-avatar>
                    </v-btn>
                </template>
                <v-card width="250" >
                    <v-card-item v-if="auth">
                        <div class="mx-auto">
                            <Link :href="`/profile/${auth.user.id}`">
                                <v-list-item
                                    :prepend-avatar="`images/profile/${auth.user.profile_pic}`"
                                    :title="auth.user.firstname + ' ' + auth.user.lastname"
                                ></v-list-item>
                            </Link>
                            <v-divider class="my-3"></v-divider>
                            <v-form @submit.prevent="request">
                                <v-btn block type="submit" :loading="form.processing" :disabled="auth.user.room_requested" variant="text"  class="text-none">
                                     {{ auth.user.room_requested ? 'Requested' : 'Request' }}
                                </v-btn>
                            </v-form>
                            <Link href="/reservations">
                                <v-btn block variant="text"  class="text-none">
                                    Reservations
                                </v-btn>
                            </Link>
                            <Link href="/wishlist"> 
                                <v-btn block variant="text" class="text-none">
                                    Wishlists 
                                </v-btn>
                            </Link>
                            <Link href="/settings">
                                <v-btn block variant="text"  class="text-none">
                                    Settings
                                </v-btn>
                            </Link>
                            <Link href="/logout" method="post">
                                <v-btn block variant="text" class="text-none">
                                    Logout
                                </v-btn>
                            </Link>
                        </div>
                    </v-card-item>
                    <v-card-item v-else>
                        <Link href="/login">
                            <v-btn block variant="text" class="text-none">
                                Log in
                            </v-btn>
                        </Link>
                        <Link href="/createUser">
                            <v-btn block variant="text" class="text-none">
                                Sign up
                            </v-btn>
                        </Link>
                    </v-card-item>
                    <v-divider/>
                    <v-card-item>
                        <Link href="/guidelines">
                            <v-btn block variant="text" class="text-none">
                                Guidelines
                            </v-btn>
                        </Link>
                        <Link href="/about">
                            <v-btn block variant="text" class="text-none">
                                About
                            </v-btn>
                        </Link>
                    </v-card-item>
                </v-card>
            </v-menu>
        </v-app-bar>
        <v-navigation-drawer v-model="sidebar" :permanent="true" location="left" temporary >
            <v-list>
                <v-list-item
                prepend-avatar="/images/profile/21.png" title="John Doe" subtitle="admin"
                ></v-list-item>
            </v-list>
            <v-divider></v-divider>
            <v-list density="compact" nav >
                <Link href="/">
                    <v-list-item prepend-icon="mdi-home" title="Home" value="home"></v-list-item>
                </Link>
                <Link href="/dashboard">
                    <v-list-item prepend-icon="mdi-view-dashboard" title="Dashboard" value="dashboard"></v-list-item>
                </Link>
                <Link href="/manage/guesthouses">
                    <v-list-item prepend-icon="mdi-home-edit" title="Guest house management" value="manageguesthouse"></v-list-item>
                </Link>
                <Link href="/manage/users">
                    <v-list-item prepend-icon="mdi-account-edit" title="User management" value="manageuser"></v-list-item>
                </Link>
                <Link href="/manage/reservations">
                    <v-list-item prepend-icon="mdi-calendar-edit" title="Reservation management" value="managereservation"></v-list-item>
                </Link>
                <Link href="/requests">
                    <v-list-item prepend-icon="mdi-help-box-multiple" title="Guest house requests" value="requests"></v-list-item>
                </Link>
                <Link href="/create/admin">
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

  <style>

  #link {
    text-decoration: none;
    color: black;
  }

  a {
    text-decoration: none;
    color: #000;
  }

</style>