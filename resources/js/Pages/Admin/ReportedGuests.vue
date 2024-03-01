<script setup>

    import {ref} from 'vue'
    import AdminLayout from '../../Layouts/AdminLayout.vue'
    import { useForm } from '@inertiajs/vue3'
    import {format} from 'date-fns'
    defineOptions({ layout: AdminLayout })
    defineProps({ reports: Object })

    const selected = ref(null)
    const viewDetailsDialog = ref(false)
    const deleteReportDialog = ref(false)
    const snackbar = ref(false)
    const headers = [
        { title: 'ID', align: 'start', key: 'id', value: "id" },
        { title: 'Reported user', align: 'center', key: 'title', value: "user_id" },
        { title: 'Reported by', align: 'center', key: 'title', value: "reporter_id" },
        { title: 'Created at', align: 'center', key: 'title', value: "created_at" },
        { title: 'Actions', align: 'center', key: 'actions', value: "actions" },
    ]

    const deleteReportForm = useForm({
        id: null
    })

    function showViewDetailsDialog(report) {
        selected.value = report
        viewDetailsDialog.value = true
    }

    function showDeleteReportDialog(report) {
        deleteReportForm.id = report.id
        deleteReportDialog.value = true
    }

    function submitDeleteReportForm() {
        deleteReportForm.delete(`/admin/delete-report/${deleteReportForm.id}`, {
            onSuccess: () => {
                snackbar.value = true
                deleteReportDialog.value = false
            }
        })
    }

</script>

<template>
    <Head title="Reported users"/>
    <v-container>
        
        <v-card width="69vw" style="margin: auto" title="Reported users">
            <v-data-table :items="reports" :headers="headers" >
                <template v-slot:item="{ item }">
                    <tr>
                        <td>{{ item.id }}</td>
                        <td class="text-center">
                            <Link :href="`/profile/${item.guest.id}`">
                                {{ item.guest.firstname + " " + item.guest.lastname }}
                            </Link>
                        </td>
                        <td class="text-center">
                            <Link :href="`/profile/${item.guest.id}`">
                                {{ item.owner.firstname + " " + item.owner.lastname }}
                            </Link>
                        </td>
                        <td class="text-center">
                            <Link :href="`/profile/${item.guest.id}`">
                                {{ format(new Date(item.created_at), 'PP') }}
                            </Link>
                        </td>
                        <td class="justify-center d-flex">
                            <v-btn @click="showViewDetailsDialog(item)" color="blue" prepend-icon="mdi-text-box-search-outline" class="text-none mt-2" size="small">View details</v-btn>
                            <v-btn @click="showDeleteReportDialog(item)" color="red" prepend-icon="mdi-delete-empty-outline" class="text-none mt-2 ms-2" size="small">Delete</v-btn>
                        </td>
                    </tr>
                </template>
            </v-data-table> 
        </v-card>
    </v-container>
    <v-dialog v-model="viewDetailsDialog" width="69%">
        <v-card>
            <v-card-title>
                <v-row>
                    <v-col cols="11">
                        Complaints about {{ selected.guest.firstname + ' ' + selected.guest.lastname }}
                    </v-col>
                    <v-col cols="1">
                        <v-btn color="red" @click="viewDetailsDialog = false" icon="mdi-close" variant="text"></v-btn>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-card elevation="0">
                    <v-card-title>
                        <v-list-item :prepend-avatar="`/images/profile/${selected.owner.profile_pic}`"
                            :title="selected.owner.firstname +' ' + selected.owner.lastname"
                            class="mb-2"
                            :subtitle="selected.owner.email">
                        </v-list-item>
                    </v-card-title>
                    <v-card-text>
                        <v-textarea label="Reason" active :value="selected.reason" variant="outlined" readonly>
                        </v-textarea>
                    </v-card-text>
                </v-card>
            </v-card-text>
        </v-card>
    </v-dialog>

    <v-dialog v-model="deleteReportDialog" width="50%">
        <v-card title="Delete report">
            <v-card-text>
                Are you sure you want to delete this report?
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn @click="deleteReportDialog = false">Close</v-btn>
                <v-btn color="red" @click="submitDeleteReportForm" :loading="deleteReportForm.processing">Delete</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-snackbar v-model="snackbar">
        Deleted successfully
    </v-snackbar>
    
</template>

<style scoped>

    a:hover {
        text-decoration: underline;
    }

</style>