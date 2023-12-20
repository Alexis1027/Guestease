<script setup>

    import MazPicker from 'maz-ui/components/MazPicker'
    import {ref, defineEmits, watch} from 'vue'
    import {format} from 'date-fns'

    const prop = defineProps(['reservedDates', 'listingType'])
    const emit = defineEmits("updateDate")
    const rangeValues = ref({
        start: undefined,
        end: undefined,
    })

    watch(rangeValues, () => {
        if(prop.listingType == 'Guest house') {
            rangeValues.value.start = rangeValues.value.start
            const startDate = new Date(rangeValues.value.start)
            const nextMonth = startDate.setMonth(startDate.getMonth() + 1)
            rangeValues.value.end = format(new Date(nextMonth), 'yyyy-MM-dd')
        }
        emit("updateDate", rangeValues)
    })
    

    const today = new Date() - 1;
    const disabledDates = []

//karon nga date
//   const karon = new Date();
// // Get the date for next month
// const nextMonth = new Date();
// nextMonth.setMonth(nextMonth.getMonth() + 1);


    //E DISABLE ANG DATES NGA NAAY RESERVATION
    if(prop.reservedDates) {
        for(let i = 0; i < prop.reservedDates.length; i++) {
            for(let date = new Date(prop.reservedDates[i].checkin); date <= new Date(prop.reservedDates[i].checkout); date.setDate(date.getDate() + 1)) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                disabledDates.push(`${year}-${month}-${day}`);
            }
        }
    }
    console.log(prop.reservedDates)
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
        noShortcuts
        format="YYYY-MM-DD"
        pickerPosition="right"
    />
</template>

