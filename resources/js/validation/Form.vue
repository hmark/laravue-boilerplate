<template>
    <form @submit.prevent="submit()" ref="form" class="row">
        <slot></slot>
        <slot name="submit" :submitting="submitting"></slot>
    </form>
</template>

<script setup lang="ts">
import { provide, reactive, ref } from 'vue'

provide('registerField', registerField)
const emit = defineEmits(['validated'])

const props = defineProps({
    onValidated: {
        type: Function,
        default: null
    }
})
const form = ref(null)
const fieldValidators = reactive<Function[]>([])
const submitting = ref(false)

function registerField(validate: Function) {
    fieldValidators.push(validate)
}

async function submit() {
    submitting.value = true

    let isValid = true
    for (let i = 0; i < fieldValidators.length; i++) {
        isValid = fieldValidators[i]() && isValid;
    }

    if (isValid) {
        emit("validated")

        if (props.onValidated && typeof props.onValidated === 'function') {
            await props.onValidated().catch(() => { })
        }
    }

    submitting.value = false
}
</script>
