<template>
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Page 1</h1>
        </div>
        <p>Hello, current time is {{ now }}</p>
    </div>
</template>

<script setup lang="ts">
import { onBeforeUnmount, ref } from "vue"
import dayjs from 'dayjs'

const now = ref(dayjs().format('MM.DD.YYYY HH:mm:ss'))
const updateTimeInterval = setInterval(() => {
    now.value = dayjs().format('MM.DD.YYYY HH:mm:ss')
}, 100)

onBeforeUnmount(() => {
    clearInterval(updateTimeInterval)
})
</script>
