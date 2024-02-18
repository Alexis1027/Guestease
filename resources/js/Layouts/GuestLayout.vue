<script setup>

    import {router} from '@inertiajs/vue3'

    const logo = '/images/logo/frlogo-transformed.png'
    const smallLogo = '/images/logo/small.png'
    function logout() {
        router.post('/logout')
    }

    defineProps({ auth: Object })

</script>

<template>
    <v-layout>
        <v-app-bar>

            <v-app-bar-title>
                <v-img :src="smallLogo" height="55" width="260" contain v-if="$vuetify.display.width <= 450"></v-img>
                <v-img :src="logo" height="55" width="260" contain v-else></v-img>
            </v-app-bar-title>
            <template v-slot:append>
                <Link href="/">
                    <v-btn :variant="$page.component == 'Guest/Index' ? 'tonal' : ''" :class="[$page.component == 'Guest/Index' ? 'text-blue' : '', 'text-none', 'mt-2']">Home</v-btn>
                </Link>
                <Link href="/about">
                    <v-btn :variant="$page.component == 'About' ? 'tonal' : ''" :class="[$page.component == 'About' ? 'text-blue' : '', 'text-none', 'mt-2']">About</v-btn>
                </Link>
                <Link href="/contact-us">
                    <v-btn :variant="$page.component == 'ContactUs' ? 'tonal' : ''" :class="[$page.component == 'ContactUs' ? 'text-blue' : '', 'text-none', 'mt-2']">Contact Us</v-btn>
                </Link>
                <div v-if="!auth">
                    <Link href="/login">
                        <v-btn icon="mdi-login" color="blue" v-if="$vuetify.display.smAndDown" ></v-btn>
                        <v-btn class="text-none mt-1" color="blue" variant="flat" v-else>
                            Register / Login
                        </v-btn>
                    </Link>
                </div>

                <v-menu min-width="200px" rounded v-else>

                    <template v-slot:activator="{ props }">
                        <v-btn class="border" size="large" v-bind="props">
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
                                <v-divider/>
                                
                                <Link @click="logout" method="post">
                                    <v-btn block variant="text" color="red" class="text-none">
                                        Logout
                                    </v-btn>
                                </Link>
                            </div>
                        </v-card-item>
                    </v-card>

                </v-menu>

            </template>
        </v-app-bar>
        <v-main>
           
            <slot></slot>
        </v-main>
    </v-layout>
</template>
<!-- 
<style scoped>

    #small {
        display: none;
    }

    #default {
        display: none;
    }

    #smalllogin {
        display: none;
    }

    @media (max-width: 700px) {

        #biglogin {
            display: none;
        }

        #smalllogin {
            display: block;
        }

        #about {
            display: none;
        }

        #home {
            display: none;
        }

        #contactus {
            display: none;
        }

        #default {
            display: block;
        }

    }
</style> -->