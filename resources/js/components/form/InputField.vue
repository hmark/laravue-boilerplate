<template>
    <div class="input-group">
        <input
            @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
            :value="modelValue"
            @keyup="validateInput"
            @blur="validateInput"
            :name="props.name"
            :type="props.type"
            :placeholder="props.placeholder"
            class="form-control"
            :disabled="props.disabled"
        />
        <div v-if="icon" class="input-group-text"><span :class="props.icon"></span></div>
        <div v-for="error in errors" class="invalid-feedback d-block">{{ error }}</div>
    </div>
</template>

<script setup lang="ts">
import { inject } from 'vue'
import useValidators from './useValidators.js'

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: '',
    },
    type: {
        type: String,
        default: 'text',
    },
    name: {
        type: String,
        default: 'name',
    },
    placeholder: {
        type: String,
        default: 'Name',
    },
    icon: {
        type: String,
        default: '',
    },
    rules: {
        type: String,
        default: '',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
})

defineEmits(['update:modelValue'])

const registerField: Function | undefined = inject('registerField')
const { validate, errors } = useValidators()

function validateInput() {
    validate(props.rules, props.name, props.modelValue)

    return errors.length === 0
}

if (registerField) {
    registerField(validateInput)
}
</script>
