<script setup>

    import {ref} from 'vue'
    import Footer from './Footer.vue';
    // import GuestHouseIndex from '../Pages/GuestHouse/index.vue'
    const sidebar = ref(false)
</script>

<template>
    <v-layout>
        <v-app-bar >
            <v-app-bar-nav-icon @click="sidebar = !sidebar"></v-app-bar-nav-icon>
            <v-toolbar-title>
                <Link href="/" id="link">Logo</Link>
            </v-toolbar-title>
            <v-spacer/>
            <v-menu min-width="200px" rounded persistent>
                <template v-slot:activator="{ props }">
                    <v-btn icon v-bind="props">
                        <v-avatar color="brown-lighten-3" size="35">
                            <v-icon>mdi-account</v-icon>
                        </v-avatar>
                    </v-btn>
                </template>
                <v-card width="250">
                    <v-card-item>
                        <div class="mx-auto text-center">
                            <h3>John Doe</h3>
                            <v-divider class="my-3"></v-divider>
                            <Link href="/reservations" id="link">
                                <v-btn block variant="text">
                                    Reservations
                                </v-btn>
                            </Link>
                            <Link href="/wishlist" id="link"> 
                                <v-btn block variant="text" class="text-start">
                                    Wishlists 
                                </v-btn>
                            </Link>
                            <Link href="/account">
                                <v-btn block variant="text">
                                    Account
                                </v-btn>
                            </Link>
                            <Link href="/logout">
                                <v-btn block variant="text">
                                    Logout
                                </v-btn>
                            </Link>
                        </div>
                    </v-card-item>
                    <v-divider/>
                    <v-card-item>
                        <Link href="/login" id="link">
                            <v-btn block variant="text">
                                Log in
                            </v-btn>
                        </Link>
                        <Link href="/register" id="link">
                            <v-btn block variant="text">
                                Sign up
                            </v-btn>
                        </Link>
                    </v-card-item>
                    <v-divider/>
                    <v-card-item>
                        <Link href="/guidelines" id="link">
                            <v-btn block variant="text">
                                Guidelines
                            </v-btn>
                        </Link>
                        <Link href="/about" id="link">
                            <v-btn block variant="text">
                                About
                            </v-btn>
                        </Link>
                    </v-card-item>
                </v-card>
            </v-menu>
        </v-app-bar>
        <v-navigation-drawer v-model="sidebar" :permanent="true" location="left" temporary>
            <v-list>
                <v-list-item
                prepend-avatar="/images/profile/ambatoPOU.jpg" title="John Doe" subtitle="admin"
                ></v-list-item>
            </v-list>
            <v-divider></v-divider>
            <v-list density="compact" nav >
                <Link href="/" id="link">
                    <v-list-item prepend-icon="mdi-home" title="Home" value="home"></v-list-item>
                </Link>
                <Link href="/dashboard" id="link">
                    <v-list-item prepend-icon="mdi-view-dashboard" title="Dashboard" value="dashboard"></v-list-item>
                </Link>
                <Link href="/rules" id="link">
                    <v-list-item prepend-icon="mdi-playlist-check" title="Rules and regulations" value="rules"></v-list-item>
                </Link>
                <Link href="/create/admin" id="link">
                    <v-list-item prepend-icon="mdi-account-hard-hat-outline" title="Create admin account" value="createadmin"></v-list-item>
                </Link>
                <Link href="/create/guesthouse" id="link">
                    <v-list-item prepend-icon="mdi-account-hard-hat-outline" title="Create guest house" value="ssd"></v-list-item>
                </Link>
            </v-list>
        </v-navigation-drawer>

        <v-main>
            <v-container>
                <slot>
                </slot>
            </v-container>
            <!-- <v-footer border class="justify-center">
                <strong> 2023 — Vuetify, LLC</strong>
            </v-footer> -->
        </v-main>

        
    </v-layout>
  </template>

  <style>

  #link {
    text-decoration: none;
    color: black;
  }

</style>