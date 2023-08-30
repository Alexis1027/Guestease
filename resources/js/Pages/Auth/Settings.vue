<script setup>

    import Layout from '../../shared/Layout.vue'
    defineOptions({layout: Layout})
    defineProps({
        auth: Object
    })
</script>


<template>
        <Head title="Settings" />
        <v-card class="bg-white">
            <v-card-item>
                <v-row>
                    <v-col cols="4">
                        <p class="text-h5">Profile information</p>
                        <p>Update your profile's account information.</p>
                    </v-col>
                    <v-col cols="2">
                        <v-avatar size="106px">
                            <v-img alt="Avatar" :src="`../images/Profile/${auth.user.profile_pic}`"></v-img>
                        </v-avatar>
                    </v-col>
                    <v-col>
                        <v-row>
                            <v-btn class="mt-5 text-none" rounded="pill" color="blue">Change picture</v-btn>
                        </v-row>
                        <v-row>
                            <v-btn class="mt-5 text-none" rounded="pill" color="red">Delete picture</v-btn>
                        </v-row>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="5">
                        <v-text-field variant="outlined" label="First name" color="blue" v-model="auth.user.firstname"></v-text-field>
                    </v-col>
                    <v-col cols="5">
                        <v-text-field variant="outlined" label="Last name" color="blue" v-model="auth.user.lastname"></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="5">
                        <v-text-field variant="outlined" label="Contact number" color="blue" v-model="auth.user.contact_no"></v-text-field>
                    </v-col>
                    <v-col cols="5">
                        <v-text-field variant="outlined" label="Address" color="blue" v-model="auth.user.address"></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="10">
                        <v-text-field variant="outlined" label="Email" color="blue" v-model="auth.user.email"></v-text-field>
                    </v-col>
                </v-row>
                <v-btn rounded="pill" class="text-none" color="blue">Save</v-btn>

            </v-card-item>
        </v-card>
        <v-card class="bg-white mt-6">
            <v-card-item>
                <v-row>
                    <v-col>
                        <p>Change password</p>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="5">
                        <v-text-field variant="outlined" label="Current password" color="blue"></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="5">
                        <v-text-field variant="outlined" label="New password" color="blue" ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="5">
                        <v-text-field variant="outlined" label="Confirm new password" color="blue"></v-text-field>
                    </v-col>
                </v-row>
                <v-btn rounded="pill" class="text-none" color="blue">Save</v-btn>
            </v-card-item>
        </v-card>
</template>

