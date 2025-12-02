<template>
    <div class="site-progress-bar fixed-top">
        <div v-show="show" class="progress rounded-0" :style="'height: ' + props.height + 'px;'">
            <transition>
                <div
                    v-if="props.active"
                    class="progress-bar progress-bar-striped progress-bar-animated"
                    :class="props.bgClass"
                    role="progressbar"
                    aria-valuenow="0"
                    aria-valuemin="0"
                    aria-valuemax="100"
                ></div>
            </transition>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { promiseTimeout } from '@vueuse/core'

const props = defineProps({
    active: {
        type: Boolean,
        default: false,
    },
    height: {
        type: Number,
        default: 4,
    },
    bgClass: {
        type: String,
        default: 'bg-primary',
    },
})

const show = ref(false)

watch(
    () => props.active,
    async (value) => {
        if (value) {
            show.value = true
        } else {
            // await promiseTimeout(1000)
            show.value = false
        }
    }
)
</script>

<style scoped>
.site-progress-bar {
    z-index: 1500;
}

.progress {
    background-color: black;
    z-index: 1500;
}

.progress-bar {
    z-index: 1500;
    width: 90%;
}

.progress-bar-animated {
    animation: 10s ease-out infinite progress-bar-stripes;
}

.v-enter-from {
    width: 0;
    opacity: 1;
}

.v-enter-active {
    transition: width 10s linear;
}

.v-leave-active {
    transition: width 0.1s linear;
    transition: opacity 0.5s ease;
}

.v-leave-to {
    width: 100%;
    opacity: 0;
}
</style>
