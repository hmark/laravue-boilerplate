<template>
    <div class="input-group">
        <input @input="$emit('update:modelValue', $event.target.value)" :value="modelValue" @keyup="validateInput" @blur="validateInput" :name="props.name"
            :type="props.type" :placeholder="props.placeholder" class="form-control" />
        <div v-for="error in errors" class="invalid-feedback d-block">{{ error }}</div>
    </div>
</template>

<script setup lang="ts">
import { inject } from 'vue'
import useValidators from "@/validation/useValidators.js"

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    type: {
        type: String,
        default: 'text'
    },
    name: {
        type: String,
        default: 'name'
    },
    placeholder: {
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
