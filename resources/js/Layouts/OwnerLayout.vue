<script setup>

    import {router} from '@inertiajs/vue3'

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
            <v-menu min-width="200px" rounded v-if="auth">
                <template v-slot:activator="{ props }">
                    <v-btn class="border me-3" size="large" v-bind="props">
                        <template v-slot:prepend>
                            <v-avatar color="blue-lighten-3" size="35">
                                <v-img :src="`/images/profile/${auth.user.profile_pic}`"></v-img>
                            </v-avatar>
                        </template>
                        <v-icon>mdi-menu</v-icon>
                    </v-btn>
                </template>
                <v-card width="250">
                    <div class="mx-auto text-center">
                        <Link :href="`/profile/${auth.user.id}`">
                            <v-btn variant="text" block class="text-none">
                                Profile
                            </v-btn>
                        </Link>
                        <Link href="/account">
                            <v-btn  variant="text" block class="text-none">
                                Account
                            </v-btn>
                        </Link>
                        
                        <v-divider/>
                        <Link @click="logout" method="post">
                            <v-btn variant="text" color="red" block class="text-none">
                                Logout
                            </v-btn>
                        </Link>
                    </div>
                </v-card>
            </v-menu>
        </v-app-bar>
        <v-main>
            <slot>
            </slot>
        </v-main>
    </v-layout>
</template>