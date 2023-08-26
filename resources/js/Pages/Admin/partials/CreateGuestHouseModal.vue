<script setup>

    import {ref, defineProps, defineEmits} from 'vue'
    import {useForm} from '@inertiajs/vue3'
    const emit = defineEmits('CloseDialog')
    const dialog = defineProps(['dialog'])
    const emitCLoseDialog = () => {
        emit('CloseDialog')
    }

    const form = useForm({
        room_name: null,
        room_image: null,
        room_details: '',
        room_price: '',
        room_location: '',
        latitude: '',
        longitude: ''
    })

    const submit = () => {
        form.post('/create/guesthouse', {
            onSuccess: () => {
                emit('CloseDialog')
                emit('showCreateSuccessfulSnackbar')
            }
        })
    }

    const imageRules = [
        value => {
            if(value.length >= 5) return true
            return `Images should have at least 5 images` 
        }
    ]

</script>

<template>
    <v-dialog v-model="dialog" width="100vw" transition="fab-transition">
        <v-container class="justify-center">
            
            <v-form @submit.prevent enctype="multipart/form-data">
                <v-row justify="center">
                    <v-card title="Create guest house" elevation="0" class="text-center" width="80%">
                        <div id="container">
                            <v-text-field variant="outlined" :error-messages="form.errors.room_name" label="Guest house name" name="room_name" v-model="form.room_name" clearable color="blue"></v-text-field>
                            <v-file-input
                                chips
                                variant="outlined"
                                prepend-inner-icon="mdi-image-outline"
                                v-model="form.room_image"
                                multiple
                                :rules="imageRules"
                                accept="image/png, image/jpeg"
                                name="room_image"
                                label="Images (minimum of 5 images)"
                                color="blue">
                                <template v-slot:selection="{ fileNames }">
                                    <template v-for="fileName in fileNames" :key="fileName">
                                        <v-chip size="small" label  color="blue" class="me-2">
                                        {{ fileName }}
                                        </v-chip>
                                    </template>
                                </template>
                            </v-file-input>
                            <v-textarea color="blue" v-model="form.room_details" :error-messages="form.errors.room_details" name="room_details" variant="outlined" label="Desciption" clearable></v-textarea>
                            <v-row>
                                <v-col cols="6">
                                    <v-text-field color="blue" v-model="form.room_price" :error-messages="form.errors.room_price" name="room_price" variant="outlined" label="Price" clearable></v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-text-field color="blue" v-model="form.room_location" name="room_location" :error-messages="form.errors.room_location" variant="outlined" label="Location" clearable></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="6">
                                    <v-text-field color="blue" v-model="form.latitude" name="latitude" :error-messages="form.errors.latitude" variant="outlined" label="Latitude" clearable></v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-text-field color="blue" v-model="form.longitude" name="longitude" :error-messages="form.errors.longitude" variant="outlined" label="Longitude" clearable></v-text-field>
                                </v-col>
                            </v-row>
                            <v-divider/>
                            <v-card-actions class="d-flex justify-end ">
                                <v-btn color="grey" class="text-none" rounded width="90" variant="flat" @click="emitCLoseDialog">Cancel</v-btn>
                                <v-btn color="green" class="text-none" rounded width="90" variant="flat" @click="submit" :loading="form.processing" type="submit">Create</v-btn>
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