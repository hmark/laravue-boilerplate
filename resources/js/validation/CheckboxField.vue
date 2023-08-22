<template>
    <div class="form-check">
        <input @input="$emit('update:modelValue', ($event.target as HTMLInputElement).checked)" :checked="modelValue" :name="props.name" class="form-check-input"
            type="checkbox" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">{{ props.label }}</label>
        <div v-for="error in errors" class="invalid-feedback d-block">{{ error }}</div>
    </div>
</template>

<script setup lang="ts">
import { inject } from 'vue'
import useValidators from "@/validation/useValidators.js"

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false
    },
    name: {
        type: String,
        default: 'name'
    },
    label: {
        type: String,
        default: 'Name'
    },
    rules: {
        type: String,
        default: ''
    }
})

defineEmits(['update:modelValue'])

const registerField: Function | undefined = inject('registerField')
const { validate, errors } = useValidators()

function validateInput() {
    validate(props.rules, props.name, (!!props.modelValue).toString())

    return errors.length === 0
}

if (registerField) {
    registerField(validateInput)
}
</script>
