<script setup>

    import {ref, defineProps, defineEmits} from 'vue'
    const emit = defineEmits('CloseDialog')
    const dialog = defineProps(['show'])
    const emitCLoseDialog = () => {
        emit('CloseDialog')
    }

    const roles = [
        'User',
        'Admin'
    ]

</script>

<template>
    <v-dialog v-model="dialog" width="85vw" transition="fab-transition">
        <v-container class="justify-center">
            <v-form>
                <v-row justify="center">
                    <v-card title="Edit User" elevation="0" class="text-center" width="80%">
                        <div id="container">
                            <v-row>
                                <v-col cols="6">
                                    <v-text-field color="blue" variant="outlined" label="First name" clearable></v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-text-field color="blue" variant="outlined" label="Last name" clearable></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="6">
                                    <v-select color="blue" variant="outlined" :items="roles" label="Role" clearable></v-select>
                                </v-col>
                                <v-col cols="6">
                                    <v-text-field color="blue" variant="outlined" label="Contact number" clearable></v-text-field>
                                </v-col>
                            </v-row>
                            <v-text-field variant="outlined" label="Address" clearable color="blue"></v-text-field>
                            <v-text-field variant="outlined" label="Email" clearable color="blue"></v-text-field>
                            
                            <v-card-actions class="d-flex justify-end">
                                <v-btn color="grey" class="text-none" rounded variant="flat" width="90" @click="emitCLoseDialog">Cancel</v-btn>
                                <v-btn color="blue" class="text-none" rounded variant="flat" width="90">Update</v-btn>
                            </v-card-actions>
                        </div>
                    </v-card>
                </v-row>
            </v-form>
        </v-container>
    </v-dialog>
</template>

<style scoped>
    #container {
        margin-left: 40px;
        margin-right: 40px;
        margin-bottom: 10px;
    }
</style>