<template>
    <div class="input-group">
        <VueDatePicker
            :model-value="date"
            @update:model-value="handleDate"
            model-type="iso"
            @blur="validateInput"
            :placeholder="props.placeholder"
            :format="props.format"
            time-picker-inline
            :start-time="startTime"
        ></VueDatePicker>
        <div v-for="error in errors" class="invalid-feedback d-block">{{ error }}</div>
    </div>
</template>

<script setup lang="ts">
import { inject, ref, watch } from 'vue'
import useValidators from './useValidators.js'

const props = defineProps({
    modelValue: {
        type: [Date, String],
        default: null,
    },
    name: {
        type: String,
        default: 'name',
    },
    format: {
        type: String,
        default: 'dd.MM.yyyy HH:mm',
    },
    placeholder: {
        type: String,
        default: 'DateTime',
    },
    rules: {
        type: String,
        default: '',
    },
    hours: {
        type: Number,
        default: 12,
    },
    minutes: {
        type: Number,
        default: 0,
    },
})

watch(props, async () => {
    handleDate(props.modelValue)
    validateInput()
})

const startTime = ref({ hours: props.hours, minutes: props.minutes })
const date = ref({})

const emit = defineEmits(['update:modelValue'])

const registerField: Function | undefined = inject('registerField')
const { validate, errors } = useValidators()

const handleDate = (newDate) => {
    date.value = newDate
    emit('update:modelValue', newDate)
}

function validateInput() {
    validate(props.rules, props.name, props.modelValue)

    return errors.length === 0
}

if (registerField) {
    registerField(validateInput)
}
</script>
