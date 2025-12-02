<template>
    <div>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            :width="width"
            :height="height"
            fill="currentColor"
            class="image-placeholder"
            :class="classes"
            viewBox=" 0 0 16 16"
        >
            <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
            <path
                d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"
            />
        </svg>
    </div>
    <ImagePickerModal ref="imagePicker" @pick="pickImage" :width="width" :height="height" :classes="classes" />
    <ImageMassUploaderModal ref="imageMassUploader" @on-uploaded="pickImages" />
    <div class="row m-0">
        <div class="col-12 p-0">
            <button @click.prevent="openImageMassUploader" :class="addButtonClasses"><i class="bi bi-upload"></i> {{ props.addButtonText }}</button>
        </div>
        <div class="col-12 p-0">
            <button @click.prevent="openImagePicker" :class="searchButtonClasses"><i class="bi bi-search"></i> {{ props.searchButtonText }}</button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useTemplateRef } from 'vue'
import ImagePickerModal from '@/admin/modals/ImagePickerModal.vue'
import ImageMassUploaderModal from '@/admin/modals/ImageMassUploaderModal.vue'

const props = defineProps({
    name: {
        type: String,
        default: 'name',
    },
    rules: {
        type: String,
        default: '',
    },
    width: {
        type: Number,
        default: 400,
    },
    height: {
        type: Number,
        default: 300,
    },
    classes: {
        type: String,
        default: 'w-100 object-fit-cover',
    },
    searchButtonClasses: {
        type: String,
        default: 'btn btn-secondary mt-1 w-100',
    },
    addButtonClasses: {
        type: String,
        default: 'btn btn-primary mt-1 w-100',
    },
    searchButtonText: {
        type: String,
        default: 'Vyhľadať Obrázok',
    },
    addButtonText: {
        type: String,
        default: 'Vložiť Obrázky',
    },
})

const imagePicker = useTemplateRef('imagePicker')
const imageMassUploader = useTemplateRef('imageMassUploader')

const emit = defineEmits(['onImagesPicked'])

function openImagePicker() {
    imagePicker.value.open()
}

function openImageMassUploader() {
    imageMassUploader.value.open()
}

function pickImage(pickedImage) {
    emit('onImagesPicked', [pickedImage])
}

function pickImages(pickedImages) {
    emit('onImagesPicked', pickedImages)
}
</script>

<style scoped lang="scss">
.image-placeholder {
    display: block;
    border: 1px solid #ced4da;
    padding: 5px;
    color: #666;
    background-color: var(--bs-body-bg);
    border: var(--bs-border-width) solid var(--bs-border-color);
    border-radius: var(--bs-border-radius);
    box-shadow: var(--bs-box-shadow-sm);
    max-width: 100%;
    height: auto;
}

.btn {
    width: auto;
}
</style>
