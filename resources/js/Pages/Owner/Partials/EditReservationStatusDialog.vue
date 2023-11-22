<script setup>

    import {router} from '@inertiajs/vue3'
    const props = defineProps(['show', 'selectedReservation', 'selectedStatus'])
    const emit = defineEmits(['closeEditReservationStatusDialog'])

    const message = new Map([
        ['approve', 'Do you want to approve this reservation?'],
        ['pending', 'Do you want to mark this reservation as pending?'],
        ['cancel', 'Are you sure, you want to cancel this reservation?'],
        ['test', 'test lang po ito']
    ])

    const statusColor = new Map([
        ['approve', 'text-green'],
        ['pending', 'text-orange'],
        ['cancel', 'text-red'],
        ['test', 'text-blue']
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
        })
    }

</script>
<template>
    <v-dialog v-model="props.show" width="auto">
        <v-sheet elevation="12" rounded="lg"  width="500" class="pa-4 text-center mx-auto">
            <p :class="['text-h5 text-center text-capitalize', statusColor.get(selectedStatus)]">{{selectedStatus}} reservation</p>
            <v-icon :class="['mb-5', statusColor.get(selectedStatus)]" :icon="icon.get(selectedStatus)" size="112"></v-icon>
            <p class="mb-4 text-medium-emphasis text-body-2">
                {{ message.get(selectedStatus) }}
            </p>
            <v-divider class="mb-4"></v-divider>
            <div class="text-end">
                <v-btn class="text-none me-4"  rounded variant="flat" width="90" @click="emit('closeEditReservationStatusDialog')" color="grey">
                    No
                </v-btn>
                <v-btn class="text-none" rounded variant="flat" width="90" color="red" @click="updateReservation" type="submit" >
                    Yes
                </v-btn>
            </div>
        </v-sheet>
    </v-dialog>
</template>