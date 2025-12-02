<template>
    <div class="wrapper position-fixed top-0 start-50 translate-middle-x p-3">
        <div
            v-for="notification in notifications"
            class="toast align-items-center text-white border-0 show rounded"
            :class="{
                'bg-success': notification.type === 'success',
                'bg-danger': notification.type === 'error',
                hiding: notification.hiding,
            }"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
        >
            <div class="d-flex">
                <div class="toast-body m-auto text-center"><strong v-if="notification.type === 'error'">Chyba:</strong> {{ notification.message }}</div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { promiseTimeout } from '@vueuse/core'

interface Notification {
    type: string
    hiding: boolean
    message: string
}

interface Props {
    notification: Notification
}

const props = defineProps<Props>()

const notifications = ref<Array<Notification>>([])

watch(
    () => props.notification,
    (value: Notification) => {
        add(value)
    }
)

async function add(notification: Notification) {
    notifications.value.push(notification)
    await promiseTimeout(notification.type === 'error' ? 5000 : 2000)
    notification.hiding = true
    await promiseTimeout(500)
    notifications.value.splice(0, 1)
}
</script>

<style scoped>
.wrapper {
    height: 0;
    z-index: 1501;
}

.show {
    position: relative;
    animation-name: slide;
    animation-duration: 0.5s;
}

@keyframes slide {
    from {
        top: -250px;
    }

    to {
        top: 0px;
    }
}

.hiding {
    opacity: 0;
    transition: opacity 0.5s linear !important;
}
</style>
