<template>
    <div>
        <DropZone class="drop-area" @files-dropped="dropFile" #active="{ active }">
            <svg
                @click="selectImages()"
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
            <button @click.prevent="selectImages" type="button" class="btn btn-secondary w-100"><i class="bi bi-upload"></i> Vložiť obrázky</button>
        </DropZone>
    </div>
    <input ref="filesInput" @input="pickFiles" type="file" accept="image/png, image/jpeg" class="d-none" multiple />
</template>

<script setup lang="ts">
import { ref } from 'vue'
import DropZone from './DropZone.vue'

const emit = defineEmits(['uploaded'])
const filesInput = ref<HTMLInputElement>()

function selectImages() {
    if (filesInput.value) {
        filesInput.value.click()
    }
}

function pickFiles() {
    let input = filesInput.value
    if (input) {
        let fileList = input.files
        for (let i = 0; i < fileList.length; i++) {
            const file = fileList[i]
            let reader = new FileReader()
            reader.onload = (e) => {
                emit('uploaded', (e.target as FileReader).result)
            }
            reader.readAsDataURL(file)
        }
    }
}

function dropFile(newFiles: any) {
    const dT = new DataTransfer()
    for (let i = 0; i < newFiles[0].length; i++) {
        dT.items.add(newFiles[0][i])
    }

    if (filesInput.value) {
        filesInput.value.files = dT.files
    }
    pickFiles()
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
