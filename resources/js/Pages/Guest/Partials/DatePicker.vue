<script setup>

    import MazPicker from 'maz-ui/components/MazPicker'
    import {ref, defineEmits, watch} from 'vue'
    

    const prop = defineProps(['reservedDates'])
    const emit = defineEmits("updateDate")
    const rangeValues = ref({
        start: undefined,
        end: undefined,
    })

    watch(rangeValues, () => {
        emit("updateDate", rangeValues)
    })

    

  const today = new Date() - 1;
  const disabledDates = []

    // DISABLE ANG DATES NGA NAAY RESERVATION
    for(let i = 0; i < prop.reservedDates.length; i++) {
        for(let date = new Date(prop.reservedDates[i].checkin); date <= new Date(prop.reservedDates[i].checkout); date.setDate(date.getDate() + 1)) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        disabledDates.push(`${year}-${month}-${day}`);
    }
    }

    // E DISABLE ANG DATES SA MGA NE-AGING ADLAW
    for (let date = new Date('2023-01-01'); date < today; date.setDate(date.getDate() + 1)) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        disabledDates.push(`${year}-${month}-${day}`);
    }


</script>

<template>
    <MazPicker
        v-model="rangeValues"
        label="Select date"
        color="primary"
        :disabledDates="disabledDates"
        double
        shortcut="undefined"
        format="YYYY-MM-DD"
        pickerPosition="right"
    />
</template>

