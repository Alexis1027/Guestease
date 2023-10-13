<script setup>

    const logo = '/images/logo/frlogo-transformed.png'
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
            <Link href="/" v-if="!auth">
                <v-btn :class="[$page.component == 'Guest/Index' ? 'text-blue' : '', 'text-none']">Home</v-btn>
            </Link>
            <Link href="/about" v-if="!auth">
                <v-btn :class="[$page.component == 'About' ? 'text-blue' : '', 'text-none']">About</v-btn>
            </Link>
            <Link href="/contact-us" v-if="!auth">
                <v-btn :class="[$page.component == 'ContactUs' ? 'text-blue' : '', 'text-none']">Contact us</v-btn>
            </Link>
            <Link href="/login" class="me-6" v-if="!auth">
                <v-btn class="text-none" color="blue" variant="flat">
                    Register / Login
                </v-btn>
            </Link>
            <v-menu min-width="200px" rounded v-if="auth">
                <template v-slot:activator="{ props }">
                    <v-btn class="border" size="large" v-bind="props" style="margin-right: 6%;">
                        <template v-slot:prepend>
                            <v-avatar color="blue-lighten-3" size="35">
                            <!-- <v-icon>mdi-account</v-icon> -->
                            <v-img :src="`../images/profile/${auth.user.profile_pic}`"></v-img>
                        </v-avatar>
                        </template>
                        <v-icon>mdi-menu</v-icon>
                    </v-btn>
                </template>
                <v-card width="250" >
                    <v-card-item>
                        <div class="mx-auto">
                            <Link :href="`/profile/${auth.user.id}`">
                                <v-list-item
                                    :prepend-avatar="`images/profile/${auth.user.profile_pic}`"
                                    :title="auth.user.firstname + ' ' + auth.user.lastname"
                                ></v-list-item>
                            </Link>
                            <v-divider class="my-3"></v-divider>
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
                            <Link href="/account">
                                <v-btn block variant="text"  class="text-none">
                                    Account
                                </v-btn>
                            </Link>
                            <Link href="/logout" method="post">
                                <v-btn block variant="text" color="red" class="text-none">
                                    Logout
                                </v-btn>
                            </Link>
                        </div>
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
        <v-main>
            <v-container>   
                <slot>
                </slot>
            </v-container>
        </v-main>

    </v-layout>
</template>

<style scoped>


</style>