<script setup>

    import Layout from '../../Layouts/AuthLayout.vue'
    defineOptions({layout: Layout})
    defineProps({auth: Object})

</script>

<template>
    <Head title="Verify" />

    <v-container>
        <v-row class="bg-white" style="margin: auto; margin-top: 8%;">
            <v-col cols="12" md="6" style="margin: auto">
                <v-card elevation="0">
                    <v-img src="../images/logo/frlogo-transformed.png"></v-img>
                </v-card>
            </v-col>
            <v-col cols="12" md="6">
                <v-card elevation="0">
                    <template v-slot:title>
                        <p class="text-center">Please verify your email.</p>
                    </template>
                    <v-card-text class="text-center">
                        <p>You're almost there! We sent a link verification to your email. </p>
                        <br>
                        <p >Just click on the link in that email to complete your signup. If you don't see it, you may need to check your spam folder.</p>
                        <br>
                        <Link href="/login">
                            <v-btn color="blue" block>Back to login</v-btn>
                        </Link>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
   </v-container>
</template>
