<script setup>

    import {defineProps, onMounted} from 'vue'
    import { useForm } from '@inertiajs/vue3';

    const prop = defineProps(['guesthouse', 'auth'])

    const items = [
        'Paypal',
        'Gcash',
        'Asdssdef',
      ]

    const form = useForm({
        // firstname: prop.auth.user.firstname,
        // lastname: prop.auth.user.lastname,
        // email: prop.auth.user.email,
        // contact_no: prop.auth.user.contact_no,
        room_id: prop.guesthouse.id,
        user_id: prop.auth.user.id,
        payment_process:'',
        status: 'pending'
    })
        
    const submit = () => {
        form.post('/reserve')
    }

    onMounted(() => {
        paypal.Buttons({
        style: {
            color:'blue',
            shape:'pill',
            layout: 'horizontal',
            tagline: 'false',
            height: 40
        },
        createOrder: function(data, actions) {
            // if(checkForm2()){
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                        value: '0.01'
                        }
                    }]
                });
            // }
            // else {
            //     alert("Fill in missing fields")
            // }
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                form.status = 'approved'
                form.post('/reserve')
                // $('#status').val('approved')
                // $('#confirm_payment_form').submit()
                // alert('Transaction completed by ' + details.payer.name.given_name + '!');
                // window.location.href = 'reservation.php'
            });
        },
        onCancel: function(data) {
            alert('cancelled')
            // $('#status').val('pending')
            // $('#confirm_payment_form').submit()
            // window.location.href = 'reservation.php'
        }
        }).render('#paypal-button-container');
    })

</script>

<template>
        <Head title="Confirm Reservation" />

        <v-container>
            <v-row>
                <v-col cols="7">
                    <v-container>
                        <v-form @submit.prevent>
                            <Link :href="`/room/${prop.guesthouse.id}`">
                                <v-btn rounded icon="mdi-keyboard-backspace" flat></v-btn>
                            </Link>
                            <label class="text-h5 font-weight-bold">Confirm Reservation</label>
                            <p class="text-h6 my-4 font-weight-bold">Choose how to pay</p>
                            <v-list>
                                <v-list-item>
                                    <template v-slot:append>
                                        <v-checkbox></v-checkbox>
                                    </template>
                                    <p class="font-weight-bold">Pay in full</p>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                </v-list-item>
                                <v-list-item>
                                    <template v-slot:append>
                                        <v-checkbox></v-checkbox>
                                    </template>
                                    <p class="font-weight-bold">Pay in full</p>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                </v-list-item>
                            </v-list>
                            <v-divider/>
                            <p class="text-h6 my-4 font-weight-bold">Pay with</p>
                            <v-select :items="items" :error-messages="form.errors.payment_process" label="Payment process" v-model="form.payment_process" clearable required variant="outlined"></v-select>
                            <v-btn block color="green" class="text-none" :loading="form.processing" @click="submit" type="submit">Confirm Reservation</v-btn>
                        </v-form>
                        <div id="paypal-button-container"></div>
                        <v-divider/>
                        <p class="text-h6 my-4 font-weight-bold">Required for your trip</p>
                            <v-list>
                                <v-list-item>
                                    <template v-slot:append>
                                        <v-btn variant="outlined" class="text-none" color="blue">Add</v-btn>
                                    </template>
                                    <p class="font-weight-bold">Message the owner</p>
                                    <p>Let the owner know why you're traveling and when you'll check in.</p>
                                </v-list-item>
                                <v-list-item>
                                    <template v-slot:append>
                                        <v-btn variant="outlined" class="text-none" color="blue">Add</v-btn>
                                    </template>
                                    <p class="font-weight-bold">Confirm phone number</p>
                                    <p>Add and confirm your phone number to get trip updates.</p>
                                </v-list-item>
                            </v-list>
                            <v-divider/>
                        <p class="text-h6 my-4 font-weight-bold">Cancellation policy</p>
                        <p>Free cancellation for 48 hours. Cancel before Nov 7 for a partial refund. Learn more</p>
                    </v-container>

                </v-col>
                <v-divider vertical></v-divider>
                <v-col cols="5">

                    <v-card class="justify-center text-center" id="card">
                        <v-card width="400" class="mt-4" style="margin-left: 8%;">
                            <v-img src="/images/room1.png"></v-img>
                        </v-card>
                        <v-card-title>
                            {{ prop.guesthouse.title }}
                        </v-card-title>
                        <v-card-text>
                            <p>{{ prop.guesthouse.location }}</p>
                        </v-card-text>
                        <v-divider/>
                        <v-card-text>
                            <!-- Price Details
                            <p>{{ prop.guesthouse.room_price }}</p> -->
                        </v-card-text>
                    </v-card>

                </v-col>
            </v-row>
        </v-container>

</template>

<style scoped>

    #card {
        margin-top: 80px;
    }

</style>