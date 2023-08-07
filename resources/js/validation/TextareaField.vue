<template>
    <div class="input-group">
        <textarea @input="$emit('update:modelValue', $event.target.value)" :value="modelValue" @keyup="validateInput" @blur="validateInput" :name="props.name"
            :rows="props.rows" :placeholder="props.placeholder" type="text" class="form-control"></textarea>
        <div v-if="errors[props.name]" class="invalid-feedback d-block">{{ errors[props.name] }}</div>
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
    name: {
        type: String,
        default: 'name'
    },
    placeholder: {
        type: String,
        default: 'Name'
    },
    rows: {
        type: String,
        default: '4'
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
