<script setup>
    import Layout from '../shared/Layout.vue'
    defineOptions({layout: Layout})
    defineProps({
        auth: Object,
        user: Object
    })

// Download the helper library from https://www.twilio.com/docs/node/install
// Set environment variables for your credentials
// Read more at http://twil.io/secure
const accountSid = "ACd6bb16db69c86824e1cc4836577d95cc";
const authToken = "4eec7d21cb548da6dc5d4e28f69a1fc1";
const verifySid = "VA678c4c11b87e1cd19c25641424aa402a";
const client = require("twilio")(accountSid, authToken);

// client.messages
//   .create({
//     body: 'Hello from twilio-node',
//     to: '+639168290756', // Text your number
//     from: '+12345678901', // From a valid Twilio number
//   })
//   .then((message) => console.log(message.sid));

// client.verify.v2
//   .services(verifySid)
//   .verifications.create({ to: "+639168290756", channel: "sms" })
//   .then((verification) => console.log(verification.status))
//   .then(() => {
//     const readline = require("readline").createInterface({
//       input: process.stdin,
//       output: process.stdout,
//     });
//     readline.question("Please enter the OTP:", (otpCode) => {
//       client.verify.v2
//         .services(verifySid)
//         .verificationChecks.create({ to: "+639168290756", code: otpCode })
//         .then((verification_check) => console.log(verification_check.status))
//         .then(() => readline.close());
//     });
//   });

</script>

<template>
    <v-row justify="center">
        
        <v-col cols="10">
            <v-container class="bg-white">
                <v-row>
                    <v-col cols="5">
                        <v-card width="390" height="250" elevation="0">
                        <v-card-item class="text-center">
                            <v-avatar size="150">
                            <v-img :src="`../images/Profile/${user.profile_pic}`"></v-img>
                        </v-avatar>
                        <p class="text-h4">{{ user.firstname + ' ' + user.lastname }}</p>
                        </v-card-item>
                    </v-card>
                
                    </v-col>
                    <v-divider vertical/>
                    <v-col cols="7">
                        <!-- About section -->
                        <v-list height="100%">
                            <v-list-item prepend-icon="mdi-home" :title="`Lives in ${user.address}`">
                        </v-list-item>
                        <v-list-item prepend-icon="mdi-facebook-messenger">
                            {{ user.firstname + ' ' + user.lastname }}
                        </v-list-item>
                        <v-list-item prepend-icon="mdi-phone" subtitle="Contact number" :title="user.contact_no">
                        </v-list-item>
                        </v-list>
                    </v-col>
                </v-row>

                <v-divider class="my-5"/>
                <!-- Owner's Guest houses section -->
                <p class="text-h5 mb-4"> {{ user.firstname }}'s guest houses</p>

                <v-row>
                    <v-col cols="4" v-for="n in 4" :key="n">
                        <v-img src="../images/room.png" class="rounded-lg" cover></v-img>
                        <strong>Guest House name</strong>
                        <p>Guest House Location</p>
                    </v-col>
                </v-row>

            </v-container>
        </v-col>
    </v-row>

</template>