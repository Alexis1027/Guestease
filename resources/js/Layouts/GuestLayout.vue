<script setup>

    import {router} from '@inertiajs/vue3'

    const logo = '/images/logo/frlogo-transformed.png'
    function logout() {
        router.post('/logout',[], {
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
        <v-app-bar scroll-behavior="elevate" scroll-threshold="438">
            <v-toolbar-title>
                <Link href="/" class="font-weight-bold">
                    <v-img :src="logo" height="55" width="260" cover></v-img>
                </Link>
            </v-toolbar-title>
            <v-spacer/>
            <!-- <v-btn variant="text" prepend-icon="mdi-search">Search</v-btn> -->
            <!-- <Link href="/joyce">
                <v-btn :class="[$page.component == 'Guest/Index' ? 'text-blue' : '', 'text-none']">wako kahibaw</v-btn>
            </Link>
            <Link href="/tepen">
                <v-btn :class="[$page.component == 'Guest/Index' ? 'text-blue' : '', 'text-none']">maot gehapon</v-btn>
            </Link>
            <Link href="/fiel">
                <v-btn :class="[$page.component == 'Guest/Index' ? 'text-blue' : '', 'text-none']">Login</v-btn>
            </Link>
            <Link href="/alexis">
                <v-btn :class="[$page.component == 'Guest/Index' ? 'text-blue' : '', 'text-none']">alexis</v-btn>
            </Link> -->
            <Link href="/">
                <v-btn :class="[$page.component == 'Guest/Index' ? 'text-blue' : '', 'text-none']">Home</v-btn>
            </Link>
            <Link href="/about">
                <v-btn :class="[$page.component == 'About' ? 'text-blue' : '', 'text-none']">About</v-btn>
            </Link>
            <Link href="/contact-us">
                <v-btn :class="[$page.component == 'ContactUs' ? 'text-blue' : '', 'text-none']">Contact us</v-btn>
            </Link>
            <Link href="/login" v-if="!auth">
                <v-btn class="text-none" color="blue" variant="flat">
                    Register / Login
                </v-btn>
            </Link>
            <v-menu min-width="200px" rounded v-if="auth">
                <template v-slot:activator="{ props }">
                    <v-btn class="border me-3" size="large" v-bind="props">
                        <template v-slot:prepend>
                            <v-avatar color="blue-lighten-3" size="35">
                                <v-img :src="`../images/profile/${auth.user.profile_pic}`"></v-img>
                            </v-avatar>
                        </template>
                        <v-icon>mdi-menu</v-icon>
                    </v-btn>
                </template>
                <v-card width="250">
                    <v-card-item>
                        <div class="mx-auto">
                            <Link href="/reservations">
                                <v-btn block variant="text" class="text-none">
                                    Reservations
                                </v-btn>
                            </Link>
                            <!-- <Link href="/notifications">
                                <v-btn block variant="text" class="text-none">
                                    <v-badge offset-x="-6" offset-y="-3" color="red" dot>
                                        Notifications 
                                    </v-badge>
                                </v-btn>
                            </Link> -->
                            <Link href="/wishlists">
                                <v-btn block variant="text" class="text-none">
                                    Wishlists 
                                </v-btn>
                            </Link>
                            
                            <Link href="/account">
                                <v-btn block variant="text"  class="text-none">
                                    Account
                                </v-btn>
                            </Link>
                            <Link @click="logout" method="post">
                                <v-btn block variant="text" color="red" class="text-none">
                                    Logout
                                </v-btn>
                            </Link>
                        </div>
                    </v-card-item>
                </v-card>
            </v-menu>
        </v-app-bar>
        <v-main>
            <slot></slot>
        </v-main>

    </v-layout>
</template>
