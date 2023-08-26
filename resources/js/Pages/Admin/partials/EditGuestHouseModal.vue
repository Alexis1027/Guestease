<script setup>

    import {ref, defineProps, defineEmits} from 'vue'
    import {useForm} from '@inertiajs/vue3'
    const emit = defineEmits('CloseDialog')
    const prop = defineProps(['show', 'guesthouse'])
    const emitCLoseDialog = () => {
        emit('CloseDialog')
    }
    const form = useForm({
        room_name: '',
        room_image: null,
        room_details: '',
        room_price: '',
        room_location: '',
        latitude: '',
        longitude: ''
    })

</script>

<template>
    <v-dialog v-model="prop.show" width="85vw" transition="fab-transition">
        <v-container class="justify-center">
            <v-form>
                <v-row justify="center">
                    <v-card title="Edit guest house" elevation="0" class="text-center" width="80%">
                        <div id="container">
                            <v-text-field variant="outlined" v-model="form.room_name" label="Name" clearable color="blue"></v-text-field>
                        <v-file-input
                            chips
                            variant="outlined"
                            prepend-inner-icon="mdi-image-outline"
                            multiple
                            label="Images"
                            color="blue">
                            <template v-slot:selection="{ fileNames }">
                                <template v-for="fileName in fileNames" :key="fileName">
                                    <v-chip size="small" label color="blue" class="me-2">
                                    {{ fileName }}
                                    </v-chip>
                                </template>
                            </template>
                        </v-file-input>
                        <v-textarea color="blue" variant="outlined" label="Desciption" clearable></v-textarea>
                        <v-row>
                            <v-col cols="6">
                                <v-text-field color="blue" variant="outlined" label="Price" clearable></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field color="blue" variant="outlined" label="Location" clearable></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="6">
                                <v-text-field color="blue" variant="outlined" label="Latitude" clearable></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field color="blue" variant="outlined" label="Longitude" clearable></v-text-field>
                            </v-col>
                        </v-row>
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