<script setup>

    import {Link} from '@inertiajs/vue3'
    import Footer from './Footer.vue';
    // import GuestHouseIndex from '../Pages/GuestHouse/index.vue'
</script>

<template>
    <v-card>
        <v-layout>
            <v-navigation-drawer
            expand-on-hover
            rail
            :permanent="true"
            >
            <v-list>
                <v-list-item
                prepend-avatar="/images/profile/ambatoPOU.jpg"
                title="John Doe"
                subtitle="john@doe.com"
                ></v-list-item>
            </v-list>
    
            <v-divider></v-divider>
    
            <v-list density="compact" nav >
                <Link href="/" id="link"><v-list-item prepend-icon="mdi-home" title="Home" value="home"></v-list-item></Link>
                <v-list-item prepend-icon="mdi-view-dashboard" title="Dashboard" value="dashboard"></v-list-item>
                <v-list-item prepend-icon="mdi-calendar-check-outline" title="View Reservations" value="View Reservations"></v-list-item>
                <Link href="/about" id="link"><v-list-item prepend-icon="mdi-information-variant" title="About" value="about"></v-list-item></Link>
                <Link href="/login" id="link"><v-list-item prepend-icon="mdi-login" title="Login" value="login"></v-list-item></Link>
            </v-list>
            </v-navigation-drawer>
    
            <v-main>
                <slot>
                    
                </slot>
                <template v-slot:placeholder>
                                <div class="d-flex align-center justify-center fill-height">
                                    <v-progress-circular
                                    color="grey-lighten-4"
                                    indeterminate
                                    ></v-progress-circular>
                                </div>
                            </template>
            <Footer></Footer>

            </v-main>
        </v-layout>
        
    </v-card>
  </template>

  <style scoped>

  #link {
    text-decoration: none;
  }

</style>