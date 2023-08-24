<script setup>

    import {ref, defineProps, defineEmits} from 'vue'
    const emit = defineEmits('CloseDialog')
    const dialog = defineProps(['show'])
    const emitCLoseDialog = () => {
        emit('CloseDialog')
    }

</script>

<template>
    <v-dialog v-model="dialog" width="50vw" transition="fab-transition">
        <v-container class="justify-center">
            <v-form @submit.prevent>
                <v-card title="DELETE GUEST HOUSE?">
                    <v-card-actions class="d-flex justify-end">
                        <v-btn color="green"  @click="emitCLoseDialog">Cancel</v-btn>
                        <v-btn color="red">Delete</v-btn>
                    </v-card-actions>
                </v-card>
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