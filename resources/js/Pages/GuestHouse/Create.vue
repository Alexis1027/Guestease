<script setup>

    import Layout from '../../shared/Layout.vue'
    defineOptions({layout: Layout})
</script>

<template>
    <Head title="Create Guest House" />
       
    <v-container class="justify-center">
        <v-form>
            <v-row justify="center">
                <v-card title="Create guest house" elevation="0" class="text-center" width="69%">
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
                    <v-btn block color="green" type="submit">Submit</v-btn>
                </v-card>
            </v-row>
        </v-form>
    </v-container>

</template>

