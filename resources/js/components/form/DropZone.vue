<template>
    <div :data-active="active" @dragenter.prevent="setActive" @dragover.prevent="setActive" @dragleave.prevent="setInactive" @drop.prevent="onDrop">
        <slot name="active" :active="active"></slot>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
const emit = defineEmits(['files-dropped'])

let active = ref(false)
let inActiveTimeout: ReturnType<typeof setTimeout>

function setActive() {
    active.value = true
    clearTimeout(inActiveTimeout)
}
function setInactive() {
    inActiveTimeout = setTimeout(() => {
        active.value = false
    }, 50)
}

function onDrop(e: DragEvent) {
    setInactive()

    if (e.dataTransfer) {
        emit('files-dropped', [...[e.dataTransfer.files]])
    }
}

function preventDefaults(e: Event) {
    e.preventDefault()
}

const events = ['dragenter', 'dragover', 'dragleave', 'drop']

onMounted(() => {
    events.forEach((eventName) => {
        document.body.addEventListener(eventName, preventDefaults)
    })
})

onUnmounted(() => {
    events.forEach((eventName) => {
        document.body.removeEventListener(eventName, preventDefaults)
    })
})
</script>
