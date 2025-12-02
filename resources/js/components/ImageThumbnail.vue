<template>
    <router-link v-if="redirect" :to="'/admin/images/' + image.id + '/edit'">
        <img
            @click="click(image)"
            :src="props.image.path"
            class="img-responsive"
            :width="width"
            :height="height"
            :class="classes + ' hover'"
            :alt="image.title"
        />
    </router-link>
    <img
        v-else
        @click="click(image)"
        :src="props.image.path"
        class="img-responsive"
        :width="width"
        :height="height"
        :class="classes + (hover ? ' hover' : '')"
        :alt="image.title"
    />
    <p v-if="showTitle" class="text-center m-0 mt-1">{{ image.title }}</p>
</template>

<script setup>
const props = defineProps({
    image: {
        type: Object,
        default: {},
    },
    width: {
        type: Number,
        default: 400,
    },
    height: {
        type: Number,
        default: 300,
    },
    hover: {
        type: Boolean,
        default: false,
    },
    classes: {
        type: String,
        default: 'w-100 object-fit-cover',
    },
    redirect: {
        type: Boolean,
        default: true,
    },
    showTitle: {
        type: Boolean,
        default: true,
    },
})

const emit = defineEmits(['imageClick'])

function click(image) {
    emit('imageClick', image)
}
</script>

<style scoped>
img {
    padding: 0.25rem;
    background-color: var(--bs-body-bg);
    border: var(--bs-border-width) solid var(--bs-border-color);
    border-radius: var(--bs-border-radius);
    box-shadow: var(--bs-box-shadow-sm);
    max-width: 100%;
    height: auto;
}

img.hover:hover {
    background-color: #0d6efd;
    opacity: 0.6;
    cursor: pointer;
}
</style>
