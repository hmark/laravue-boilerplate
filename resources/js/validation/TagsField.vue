<template>
    <div class="tags p-0 mb-0">
        <li v-for="tag in props.modelValue" class="btn btn-sm btn-secondary pl-0 ml-0 mr-1 my-1">
            {{ tag }} <i @click.prevent="remove(tag)" class="bi bi-x-lg ms-2"></i>
        </li>
    </div>
    <input ref="inputRef" v-model="input" @keyup.enter="addInputTag" @blur="addInputTag" type="text" autocomplete="off" spellcheck="false" :name="props.name"
        :placeholder="props.placeholder" class="form-control">
    <div class="dropdown m-0 p-0">
        <ul class="dropdown-menu tags-selection show m-0 border-top-0 w-100" :class="{ 'd-none': input === '' || availableTags.length === 0 }">
            <li v-for="tag in availableTags" @mousedown="addTag(tag)" @touchstart="addTag(tag)" class="tag-selection">
                {{ tag }}
            </li>
        </ul>
    </div>
    <button @click.prevent="" class="btn d-none">Add</button>
</template>

<script setup lang="ts">
import { computed, inject, ref } from 'vue'
import useValidators from "@/validation/useValidators.js"

const props = defineProps({
    modelValue: {
        type: Array,
        default: []
    },
    name: {
        type: String,
        default: 'tags'
    },
    placeholder: {
        type: String,
        default: 'Tags'
    },
    rules: {
        type: String,
        default: ''
    },
    existingTags: {
        type: Array,
        default: []
    },
})

const emit = defineEmits(['update:modelValue'])

const input = ref('')
const inputRef = ref(null)
const availableTags = computed(() => {
    if (input.value !== '') {
        var selectedTags = props.modelValue.map(tag => tag.toLowerCase())
        var tags = props.existingTags.filter(tag => !selectedTags.includes(tag.toLowerCase()))
        tags.sort()
        tags = tags.filter(tag => tag.toLowerCase().indexOf(input.value.toLowerCase()) !== -1)
        return tags.slice(0, 10)
    }
    else {
        return []
    }
})

const registerField = inject('registerField')
const { validate, errors } = useValidators()

function validateInput() {
    validate(props.rules, props.name, props.modelValue)

    return errors.length === 0
}

function remove(tag) {
    props.modelValue.splice(props.modelValue.indexOf(tag), 1)
}

function addInputTag() {
    input.value = input.value.trim()
    if (input.value != '') {
        addTag(input.value)
        input.value = ''
    }
}

function addTag(tag) {
    props.modelValue.push(tag)
    emit('update:modelValue', props.modelValue)
    input.value = ''
    inputRef.value.focus()
}

registerField(validateInput)
</script>

<style scoped>
.tags :where(.title, li, li i, .details) {
    display: flex;
    align-items: center;
}

.bi:hover {
    background-color: var(--bs-secondary);
    color: white;
}

.tags {
    background-color: white;
    display: flex;
    flex-wrap: wrap;
    padding: 7px;
}

.tags li {
    color: white;
    list-style: none;
    border-radius: 5px;
    border: 1px solid #e3e1e1;
    font-weight: 800;
    background-color: var(--bs-dark);
}

.tags li i:hover {
    background-color: var(--bs-primary);
}

.tags li i {
    height: 20px;
    width: 20px;
    color: white;
    margin-left: 8px;
    font-size: 12px;
    cursor: pointer;
    border-radius: 50%;
    justify-content: center;
}

input:focus+.tags-selection {
    display: block;
}

.tags-selection {
    left: 0px;
    background-color: white;
    flex-wrap: wrap;
    padding: 0px;
    padding-top: 1px;
    border: 1px solid #e3e1e1;
    border-top: 0px;
}

.tags-selection li {
    color: black;
    margin: 4px 3px;
    list-style: none;
    padding: 5px 10px;
    font-weight: 800;
    cursor: pointer;
}

.tags-selection li:hover {
    color: white;
    background-color: var(--bs-secondary);
}

.dropdown {
    z-index: 3;
}
</style>
