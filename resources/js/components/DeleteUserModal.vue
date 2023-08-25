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
            <v-form>
                <v-sheet elevation="12" max-width="600" rounded="lg" width="100%" class="pa-4 text-center mx-auto">
                    <v-icon class="mb-5" color="red" icon="mdi-close-circle" size="112"></v-icon>
                    <h2 class="text-h5 mb-6">Are you sure?</h2>

                    <p class="mb-4 text-medium-emphasis text-body-2">
                        This will delete user <strong>(USER NAME)</strong>
                        <br> This process cannot be undone.
                    </p>
                    <v-divider class="mb-4"></v-divider>
                    <div class="text-end">
                        <v-btn class="text-none me-4" @click="emitCLoseDialog" color="grey" rounded variant="flat" width="90">
                            Cancel
                        </v-btn>
                        <v-btn class="text-none" color="red" rounded variant="flat" width="90">
                            Delete
                        </v-btn>
                    </div>
                </v-sheet>
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