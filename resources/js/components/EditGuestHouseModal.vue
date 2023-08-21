<script setup>

    import {ref, defineProps, defineEmits} from 'vue'
    const emit = defineEmits('CloseDialog')
    const dialog = defineProps(['show'])
    const emitCLoseDialog = () => {
        emit('CloseDialog')
    }

</script>

<template>
    <v-dialog v-model="dialog" width="85vw" transition="fab-transition">
        <v-container class="justify-center">
            <v-form>
                <v-row justify="center">
                    <v-card title="Update guest house" elevation="0" class="text-center" width="80%">
                        <div id="container">
                            <v-text-field variant="outlined" label="Name" clearable color="blue"></v-text-field>
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
                            <v-btn color="red" @click="emitCLoseDialog">Cancel</v-btn>
                            <v-btn color="green" >Update</v-btn>
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