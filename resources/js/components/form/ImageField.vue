<template>
    <div v-if="props.modelValue" class="preview">
        <img v-if="props.modelValue" :src="props.modelValue" class="image-preview img-responsive w-100" />
        <button v-if="props.modelValue" @click.prevent="removeImage" type="button" class="btn btn-secondary w-100">
            <i class="bi bi-pencil-square"></i> Zmeniť obrázok
        </button>
    </div>
    <div v-else>
        <DropZone class="drop-area" @files-dropped="dropFile" #active="{ active }">
            <svg
                @click="selectImage()"
                :class="{ active: active }"
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                class="image-drop w-100"
                viewBox=" 0 0 16 16"
            >
                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                <path
                    d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"
                />
            </svg>
            <button @click.prevent="selectImage" type="button" class="btn btn-secondary w-100"><i class="bi bi-upload"></i> Vložiť obrázok</button>
        </DropZone>
    </div>
    <input ref="fileInput" @input="pickFile" :name="props.name" type="file" accept="image/png, image/jpeg" class="d-none" />
    <div v-for="error in errors" class="invalid-feedback d-block">{{ error }}</div>
</template>

<script setup lang="ts">
import { inject, nextTick, ref } from 'vue'
import useValidators from './useValidators.js'
import DropZone from './DropZone.vue'

const fileInput = ref<HTMLInputElement>()

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    name: {
        type: String,
        default: 'name',
    },
    rules: {
        type: String,
        default: '',
    },
})

const emit = defineEmits(['update:modelValue'])

const registerField: Function | undefined = inject('registerField')
const { validate, errors } = useValidators()

function validateInput() {
    validate(props.rules, props.name, props.modelValue)

    return errors.length === 0
}

function lateValidateInput() {
    // emit model change is not propagated immediately so we have to wait with validation
    nextTick(() => {
        validateInput()
    })
}

function selectImage() {
    if (fileInput.value) {
        fileInput.value.click()
    }
}

function pickFile() {
    let input = fileInput.value
    if (input) {
        let file = input.files
        if (file && file[0]) {
            let reader = new FileReader()
            reader.onload = (e) => {
                setImage((e.target as FileReader).result)
            }
            reader.readAsDataURL(file[0])
        }
    }
}

function setImage(image: string | ArrayBuffer | null) {
    emit('update:modelValue', image)
    lateValidateInput()
}

function removeImage() {
    const dT = new DataTransfer()
    if (fileInput.value) {
        fileInput.value.files = dT.files
    }
    setImage(null)
}

function dropFile(newFiles: any) {
    const dT = new DataTransfer()
    dT.items.add(newFiles[0][0])
    if (fileInput.value) {
        fileInput.value.files = dT.files
    }
    pickFile()
}

if (registerField) {
    registerField(validateInput)
}
</script>

<style scoped lang="scss">
.image-drop {
    height: 200px;
    display: block;
    cursor: pointer;
    background-size: cover;
    background-position: center center;
    border: 1px solid #ced4da;
    padding: 50px;
    background-color: white;
    color: #666;
    display: block;
    margin: auto;
}

.image-drop.active {
    background-color: #aaa;
}

button {
    display: block;
    margin: auto;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-left-radius: 2px;
    border-bottom-right-radius: 2px;
}

html,
body {
    height: 100%;
}
</style>
