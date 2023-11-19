<script setup>

    import {ref, defineProps} from 'vue'
    import {router} from '@inertiajs/vue3'
    const sidebar = ref(false)
    const logo = '/images/logo/frlogo-transformed.png'
    const {auth} = defineProps(['auth'])

    function logout() {
        router.post('/logout')
        location.href = '/'
        window.history.replaceState({}, document.title, '/')
    }
    

</script>

<template>
    <v-layout>
        <v-app-bar scroll-behavior="elevate" scroll-threshold="438">
            <v-toolbar-title>
                <Link href="/" class="font-weight-bold">
                    <v-img :src="logo" height="55" width="260" cover></v-img>
                </Link>
            </v-toolbar-title>
            <!-- <v-spacer/>

            <v-text-field label="Search..." class="mt-5" clearable flat rounded prepend-inner-icon="mdi-magnify" v-model="search" variant="outlined" color="blue">
            </v-text-field> -->
            <v-spacer/>
            <Link href="/" v-if="!auth">
                <p>Homee</p>
            </Link>
            <Link href="/" class="ms-4" v-if="!auth">
                <p>About</p>
            </Link>
            <Link href="/login" class="ms-4 me-6" v-if="!auth">
                <v-btn class="text-none" color="blue" variant="flat">
                    Register / Login
                </v-btn>
            </Link>
            <v-menu min-width="200px" rounded v-if="auth">
                <template v-slot:activator="{ props }">
                    <v-btn icon v-bind="props" style="margin-right: 6%;">
                        <v-avatar color="blue-lighten-3" size="35">
                            <v-icon>mdi-account</v-icon>
                        </v-avatar>
                    </v-btn>
                </template>
                <v-card width="250" >
                    
                    <v-card-item v-if="auth">
                        <div class="mx-auto">
                            <Link :href="`/profile/${auth.user.id}`">
                                <v-btn block variant="text" class="text-none">
                                    Profile
                                </v-btn>
                            </Link>
                        </div>
                        <div class="mx-auto">
                            <Link href="/account">
                                <v-btn block variant="text" class="text-none">
                                    Account
                                </v-btn>
                            </Link>
                        </div>
                        <div class="mx-auto">
                            <Link @click="logout" method="post">
                                <v-btn block variant="text" class="text-none">
                                    Logout
                                </v-btn>
                            </Link>
                        </div>
                    </v-card-item>
                </v-card>
            </v-menu>
        </v-app-bar>
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