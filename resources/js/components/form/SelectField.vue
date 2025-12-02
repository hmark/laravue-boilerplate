<template>
    <div class="input-group">
        <select @input="onInput" :value="modelValue" :name="props.name" :placeholder="props.placeholder" class="form-select">
            <option disabled value="">{{ props.placeholder }}</option>
            <option v-for="option in props.options" :value="option.id">{{ option.title }}</option>
        </select>
        <div v-if="icon" class="input-group-text"><span :class="props.icon"></span></div>
        <div v-for="error in errors" class="invalid-feedback d-block">{{ error }}</div>
    </div>
</template>

<script setup lang="ts">
import { inject, nextTick } from 'vue'
import useValidators from './useValidators.js'

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: 0,
    },
    name: {
        type: String,
        default: 'name',
    },
    placeholder: {
        type: String,
        default: 'Name',
    },
    options: {
        type: Array,
        default: [],
    },
    icon: {
        type: String,
        default: '',
    },
    rules: {
        type: String,
        default: '',
    },
})

const emit = defineEmits(['update:modelValue'])

const registerField: Function | undefined = inject('registerField')
const { validate, errors } = useValidators()

function onInput(event) {
    emit('update:modelValue', (event.target as HTMLInputElement).value)

    nextTick(() => {
        validateInput()
    })
}

function validateInput() {
    validate(props.rules, props.name, props.modelValue)

    return errors.length === 0
}

if (registerField) {
    registerField(validateInput)
}
</script>
