<script setup>

    import {ref, defineProps, defineEmits} from 'vue'
    import {router} from '@inertiajs/vue3'
    const emit = defineEmits(['CloseDialog', 'showDeleteSuccessfulSnackbar'])
    const prop = defineProps(['show', 'listing'])
    const emitCLoseDialog = () => {
        emit('CloseDialog')
    }

    const submit = () => {
        router.delete(`/owner/delete-listing/${prop.listing.id}`, {
            onFinish: () => {
                emit('CloseDialog')
                emit('showDeleteSuccessfulSnackbar')

            }
        })
    }

</script>

<template>
    <v-dialog v-model="prop.show" width="50vw" transition="fab-transition">
        <v-container class="justify-center">
            <v-form @submit.prevent>
                <v-sheet elevation="12" max-width="600" rounded="lg" width="100%" class="pa-4 text-center mx-auto">

                    <v-icon class="mb-5" color="red" icon="mdi-close-circle" size="112"></v-icon>
                    <h2 class="text-h5 mb-6">Are you sure?</h2>
                    <p class="mb-4 text-medium-emphasis text-body-2">
                        Do you really want to delete guest house <strong>{{ prop.listing.title }}</strong>
                        <br> This process cannot be undone.
                    </p>
                    <v-divider class="mb-4"></v-divider>
                    <div class="text-end">
                        <v-btn class="text-none me-4"  rounded variant="flat" width="90" @click="emitCLoseDialog" color="grey">
                            Cancel
                        </v-btn>
                        <v-btn class="text-none" rounded variant="flat" width="90" color="red" @click="submit" type="submit" >
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