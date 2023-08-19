<script setup>

    import {defineProps} from 'vue'
    import { useForm } from '@inertiajs/vue3';

    const prop = defineProps(['guesthouse'])

    const items = [
        'Paypal',
        'Gcash',
        'Asdssdef',
      ]

    const form = useForm({
        firstname: '',
        lastname: '',
        email: '',
        contact_no: '',
    })
        
    

      paypal.Buttons({
        style: {
            color:'blue',
            shape:'pill',
            layout: 'horizontal',
            tagline: 'false',
            height: 40
        },
        createOrder: function(data, actions) {
            if(checkForm2()){
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                        value: '0.01'
                        }
                    }]
                });
            }
            else {
                alert("Fill in missing fields")
            }
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                $('#status').val('approved')
                $('#confirm_payment_form').submit()
                alert('Transaction completed by ' + details.payer.name.given_name + '!');
                // window.location.href = 'reservation.php'
            });
        },
        onCancel: function(data) {
            $('#status').val('pending')
            $('#confirm_payment_form').submit()
            // window.location.href = 'reservation.php'
        }
        }).render('#paypal-button-container');

</script>

<template>
        <Head title="Confirm Reservation" />

        <v-container>
            <v-row>
                <v-col cols="6">
                    <v-container>
                        <Link :href="`/room/${prop.guesthouse.id}`">
                            <v-btn rounded icon="mdi-keyboard-backspace" flat></v-btn>
                        </Link>
                        <label class="text-h5">Confirm Reservation</label>
                        <p class="text-h6 my-4">Personal Information</p>
                        <v-text-field variant="outlined" color="blue" clearable label="First name" v-model="form.firstname"></v-text-field>
                        <v-text-field variant="outlined" color="blue" clearable label="Last name" v-model="form.lastname"></v-text-field>
                        <v-text-field variant="outlined" color="blue" clearable label="Email" placeholder="johndoe@gmail.com" v-model="form.email"></v-text-field>
                        <v-text-field variant="outlined" color="blue" clearable label="Contact Number" v-model="form.contact_no"></v-text-field>
                        <v-select :items="items" label="Payment process" clearable required variant="outlined"></v-select>
                        <v-btn block color="green">Confirm Reservation</v-btn>
                        <div id="paypal-button-container"></div>
                    </v-container>

                </v-col>
                <v-divider vertical></v-divider>
                <v-col cols="6">

                    <v-card class="justify-center text-center" id="card">
                        <v-card width="400" class="mt-4" style="margin-left: 16%;">
                            <v-img src="/images/room1.png"></v-img>
                        </v-card>
                        <v-card-title>
                            Guest House {{ prop.guesthouse.room_name }}
                        </v-card-title>
                        <v-card-text>
                            <p>{{ prop.guesthouse.room_details }}</p>
                        </v-card-text>
                        <v-divider/>
                        <v-card-text>
                            Price Details
                            <p>{{ prop.guesthouse.room_price }}</p>

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