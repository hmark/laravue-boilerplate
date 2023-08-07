<template>
    <div class="form-check">
        <input @input="$emit('update:modelValue', $event.target.checked)" :checked="modelValue" :name="props.name" class="form-check-input" type="checkbox"
            id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">{{ props.label }}</label>
        <div v-if="errors[props.name]" class="invalid-feedback d-block">{{ errors[props.name] }}</div>
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

const registerField = inject('registerField')
const { validate, errors } = useValidators()

function validateInput() {
    validate(props.rules, props.name, props.modelValue)

    return errors.length === 0
}

registerField(validateInput)
</script>
