<script setup>

    defineOptions({layout: Layout})
    defineProps({ auth: Object, user: Object, listings: Object })
    import Layout from '../Layouts/Layout.vue'
    import {format} from 'date-fns'
    import { ref } from 'vue'
    import { useForm } from '@inertiajs/vue3'

    const snackbar = ref(false)
    const reportUserDialog = ref(false)
    const reportUserForm = useForm({
        user_id: null,
        reason: null,
    })

    function submitReportUserForm() {
        reportUserForm.post('/report-user', {
            onSuccess: () => {
                snackbar.value = true
                reportUserDialog.value = false
                reportUserForm.reset()
            },
            onError: (error) => {
                console.log(error)
            }
        })
    }

    function setUserId(user) {
        reportUserForm.user_id = user.id
        reportUserDialog.value = true
    }

</script>

<template>
    <Head :title="user.firstname + ' ' + user.lastname "></Head>
    <v-row justify="center">
        <v-container class="bg-white">
            <v-row>
                <v-col cols="12" sm="12" md="5" lg="5" xl="5" xxl="5">
                    <v-card width="390" height="250" elevation="0">
                    <v-card-item class="text-center">
                        <v-avatar size="150">
                        <v-img :src="`/images/profile/${user.profile_pic}`"></v-img>
                    </v-avatar>
                    <p class="text-h4 text-capitalize">{{ user.firstname + ' ' + user.lastname }} <span v-if="user.role == 'guest'" class="text-h6">({{ user.role }})</span> </p>
                    </v-card-item>
                </v-card>
            
                </v-col>
                <v-divider vertical/>
                <v-col cols="12" sm="12" md="7" xl="7" xxl="7">
                    <!-- About section -->
                    <v-list height="100%">
                        <v-list-item v-if="user.address" prepend-icon="mdi-home" :subtitle="`Lives in`">
                            {{ user.address }}
                        </v-list-item>
                        <v-list-item prepend-icon="mdi-facebook-messenger" subtitle="Messenger" class="text-capitalize">
                            {{ user.firstname + ' ' + user.lastname }}
                        </v-list-item>
                        <v-list-item prepend-icon="mdi-email-open" subtitle="Email">
                            {{ user.email }}
                        </v-list-item>
                        <v-list-item prepend-icon="mdi-phone" subtitle="Contact number">
                            {{ user.phone_number }}
                        </v-list-item>
                        <v-list-item prepend-icon="mdi-calendar-range" subtitle="Joined at">
                                {{ format(new Date(user.created_at), 'MMMM dd, y') }}
                        </v-list-item>
                        <v-list-item v-if="auth && auth.user.id != user.id">
                            <v-btn prepend-icon="mdi-flag" @click="setUserId(user)" color="red">Report user</v-btn>
                        </v-list-item>
                    </v-list>
                </v-col>
            </v-row>

            <v-divider class="my-5"/>
            <!-- Owner's Guest houses section -->
            <div v-if="user.role == 'owner'">
                <p class="text-h5 mb-4"> {{ user.firstname }}'s listings </p> 
            <v-row v-if="listings.length > 0">
                <v-col cols="12" sm="6" md="4" lg="4" xl="4" xxl="4" v-for="listing in listings" :key="listing.id">
                    <Link :href="`/room/${listing.id}`">
                        <v-card>
                            <v-img :src="`/images/uploads/${JSON.parse(listing.images)[0]}`" class="rounded-lg" height="300" cover max-height="300"></v-img>
                            <v-card-text>
                                <strong>{{ listing.title }}</strong>
                                <p>{{ listing.location }}</p>
                            </v-card-text>
                        </v-card>
                    </Link>
                </v-col>
            </v-row>
            <p v-else>
                This user does not have a listing yet.
            </p>
            </div>
            <v-dialog v-model="reportUserDialog" width="69%">
                <v-card title="Report guest">
                    <v-divider class="mt-2" />
                    <v-card-text>
                        <v-list-item :title="user.firstname + ' ' + user.lastname" :subtitle="user.email">
                            <template v-slot:prepend>
                                <v-avatar size="60">
                                    <v-img cover :src="`/images/profile/${user.profile_pic}`"></v-img>
                                </v-avatar>
                            </template>
                        </v-list-item>
                        <v-textarea label="Reason" color="blue" v-model="reportUserForm.reason" :error-messages="reportUserForm.errors.reason" class="mt-2"></v-textarea>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn @click="reportUserDialog = false">Close</v-btn>
                        <v-btn color="red" @click="submitReportUserForm" :loading="reportUserForm.processing">Submit</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
        <v-snackbar v-model="snackbar" color="blue-lighten-3" timeout="1500">
            User reported successfully
            <template v-slot:actions>
                <v-btn variant="text" @click="snackbar = false" icon="mdi-close">
                </v-btn>
            </template>
        </v-snackbar>
    </v-row>

</template>