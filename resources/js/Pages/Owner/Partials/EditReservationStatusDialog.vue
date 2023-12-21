<script setup>

    import {router} from '@inertiajs/vue3'
    const props = defineProps(['show', 'selectedReservation', 'selectedStatus'])
    const emit = defineEmits(['closeEditReservationStatusDialog', 'updateSuccessful'])

    const message = new Map([
        ['approve', 'Do you want to approve this reservation?'],
        ['pending', 'Do you want to mark this reservation as pending?'],
        ['cancel', 'Are you sure, you want to cancel this reservation?  This process cannot be undone.'],
        ['test', 'test lang po ito']
    ])

    const statusColor = new Map([
        ['approve', 'green'],
        ['pending', 'orange'],
        ['cancel', 'red'],
        ['test', 'blue']
    ])

    const icon = new Map([
        ['approve', 'mdi-check-circle'],
        ['pending', 'mdi-timer-sand'],
        ['cancel', 'mdi-close-circle'],
        ['test', 'mdi-bed']
    ])

    function updateReservation() {
        emit('closeEditReservationStatusDialog')
        const status = new Map([
            ['approve', 'approved'],
            ['pending', 'pending'],
            ['cancel', 'cancelled'],
        ])
        router.put(`/owner/update-reservation/${props.selectedReservation.id}`, {
            status: status.get(props.selectedStatus),
            listing_id: props.selectedReservation.listing_id
        }, {
            onSuccess: () => {
                emit('updateSuccessful')
            }
        })
    }

</script>
<template>
    <v-dialog v-model="props.show" width="auto">
        <v-sheet elevation="12" rounded="lg"  width="500" class="pa-4 text-center mx-auto">
            <p :class="['text-h5 text-center text-capitalize', `text-${statusColor.get(selectedStatus)}`]">{{selectedStatus}} reservation</p>
            <v-icon :class="['mb-5', `text-${statusColor.get(selectedStatus)}`]" :icon="icon.get(selectedStatus)" size="112"></v-icon>
            <p class="mb-4 text-medium-emphasis text-body-2">
                {{ message.get(selectedStatus) }}
            </p>
            <v-divider class="mb-4"></v-divider>
            <div class="text-end">
                <v-btn class="text-none me-4"  variant="text" width="90" @click="emit('closeEditReservationStatusDialog')" >
                    No
                </v-btn>
                <v-btn class="text-none"  variant="flat" width="90" :color="statusColor.get(selectedStatus)" @click="updateReservation" type="submit" >
                    Yes
                </v-btn>
            </div>
        </v-sheet>
    </v-dialog>
</template>