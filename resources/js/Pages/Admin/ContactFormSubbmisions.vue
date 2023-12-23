<script setup>

    defineOptions({layout: AdminLayout})
    defineProps({ messages: Object })
    import AdminLayout from '../../Layouts/AdminLayout.vue'
    import {reactive, ref} from 'vue'
    import emailjs from '@emailjs/browser'
import { useForm } from '@inertiajs/vue3'

    const snackbar = ref(false)
    const message = ref('')
    const reply = ref('')
    const replyDialog = ref(false)
    const deleteMessageDialog = ref(false)
    const replyForm = reactive({
        reply: null,
        subject: null,
        user_email: null,
        user_name: null
    })

    const deleteMessageForm = useForm({
        id: null
    })

    function showReplyDialog(message) {
        replyDialog.value = true
        replyForm.user_email = message.email
        replyForm.user_name = message.name
    }
    
    function showDeleteMessageDialog(message) {
        deleteMessageDialog.value = true
        deleteMessageForm.id = message.id
        replyForm.user_email = message.email
        replyForm.user_name = message.name
    }

    function sendNotification() {
        emailjs.send('service_kfsphbh', 'template_xzp03ja', 
        {
            sendername: "Guestease team",
            to: `${replyForm.user_email}`,
            subject: `${replyForm.subject}`,
            replyto: "guestease@team.com",
            message: `Dear ${replyForm.user_name},

                ${replyForm.reply}

                Best regards,
                Guestease Team`
            }
        , 'eEt-YCYeYc0LoTRxJ').then(() => {
            replyDialog.value = false
            snackbar.value = true
            message.value = 'Reply sent successfully'
        })
    }

    function deleteMessage() {
        deleteMessageForm.delete(`/admin/delete-message/${deleteMessageForm.id}`, {
            onSuccess: () => {
                message.value = 'MEssage deleted successfully'
                snackbar.value = true
                deleteMessageDialog.value = false
            }
        })
    }

    const headers = [
        { title: 'ID', align: 'start', key: 'id', value: "id" },
        { title: 'Name', align: 'start', key: 'name', value: "name" },
        { title: 'Email', align: 'start', key: 'email', value: "email" },
        { title: 'Message', align: 'start', key: 'message', value: "message" },
        { title: 'Actions', align: 'start', key: 'type', value: "type" },
    ]

</script>

<template>
    <Head title="Create admin" />
    <v-container>
        <v-card title="Contact us submissions">
            <v-data-table :items="messages" :headers="headers">
                <template v-slot:item="{item}">
                    <tr>
                        <td>{{ item.id }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.message }}</td>
                        <td>
                            <v-btn icon="mdi-message-processing-outline" size="small" @click="showReplyDialog(item)"></v-btn>
                            <v-btn icon="mdi-delete-empty-outline" size="small" @click="showDeleteMessageDialog(item)"></v-btn>
                        </td>
                    </tr>
                </template>
            </v-data-table>
        </v-card>
    </v-container>

    <v-dialog v-model="replyDialog">
        <v-card title="Admin feedback">
            <v-card-item>
                {{ replyForm }}
                <v-text-field label="Subject" v-model="replyForm.subject"></v-text-field>
                <v-textarea v-model="replyForm.reply"></v-textarea>
            </v-card-item>
            <v-card-actions>
                <v-spacer/>
                <v-btn @click="sendNotification">Submit</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="deleteMessageDialog" width="auto">
        <v-card title="Delete message">
            <v-card-item>
                <v-alert icon="mdi-alert" color="red-lighten-4" elevation="2" class="text-start text-error">
                    After you delete a message, it's permanently deleted. Messages can't be undeleted.
                </v-alert>
                <p class="ma-4  text-body-2 text-start">
                    User <br>
                    <strong class="text-h6">{{ replyForm.user_name }}</strong>
                </p>
            </v-card-item>
            <v-card-actions>
                <v-spacer/>
                <v-btn @click="deleteMessageDialog = false">CLose</v-btn>
                <v-btn @click="deleteMessage" :loading="deleteMessageForm.processing" color="red">Delete</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-snackbar v-model="snackbar" color="blue-lighten-3" timeout="1500">
        {{ message }}
    </v-snackbar>
</template>

