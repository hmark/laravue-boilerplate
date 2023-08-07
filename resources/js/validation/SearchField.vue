<template>
    <div class="tags p-0 mb-0">
        <li v-for="tag in props.pickedTags" class="btn btn-sm btn-secondary pl-0 ml-0 mr-1 my-1">
            {{ tag }} <i @click.prevent="remove(tag)" class="bi bi-x-lg ms-2"></i>
        </li>
    </div>
    <div class="input-group p-0 mt-0">
        <input :value="props.modelValue" @input="onInput($event)" @blur="onBlur()" @keyup.enter="$event.target.blur()" type="text" class="form-control"
            autocomplete="off" spellcheck="false" :placeholder="props.placeholder">
        <button ref="button" class="btn btn-primary px-4"><i class="bi bi-search fw-bolder"></i></button>
    </div>
    <div class="dropdown m-0 p-0">
        <ul class="dropdown-menu tags-selection show m-0 border-top-0 w-100" :class="{ 'd-none': !isFocused || availableTags.length === 0 }">
            <li v-for="tag in availableTags" @mousedown.prevent="addTag(tag)" class="tag-selection">
                {{ tag }}
            </li>
        </ul>
    </div>
</template>

<script setup lang="ts">
import { computed, inject, ref } from 'vue'
import useValidators from "@/validation/useValidators.js"

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
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
    pickedTags: {
        type: Array,
        default: []
    }
})

const emit = defineEmits(['update:modelValue'])

const button = ref(null)
const isFocused = ref(false)
const availableTags = computed(() => {
    if (props.modelValue !== '') {
        var selectedTags = props.pickedTags.map(tag => tag.toLowerCase())
        var tags = props.existingTags.filter(tag => !selectedTags.includes(tag.toLowerCase()))
        tags.sort()
        tags = tags.filter(tag => tag.toLowerCase().indexOf(props.modelValue.toLowerCase()) !== -1)
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
    props.pickedTags.splice(props.pickedTags.indexOf(tag), 1)
    submit()
}

function addTag(tag) {
    props.pickedTags.push(tag)
    props.modelValue = ''
    emit('update:modelValue', '')
    submit()
}

function submit() {
    button.value.click()
}

function onInput(event) {
    emit('update:modelValue', event.target.value)
    isFocused.value = true
}

function onBlur() {
    isFocused.value = false
}

registerField(validateInput)
</script>

<style scoped>
.tags :where(.title, li, li i, .details) {
    display: flex;
    align-items: center;
}

.bi:hover {
    color: white;
}

input {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

input:focus {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

.tags {
    background-color: white;
    display: flex;
    flex-wrap: wrap;
    padding: 7px;
    border-bottom: 0px;
}

.tags li {
    color: white;
    list-style: none;
    border-radius: 5px;
    padding: 5px 8px 5px 10px;
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
    background-color: white;
    flex-wrap: wrap;
    padding: 0px;
    padding-top: 1px;
    border: 1px solid #e3e1e1;
    border-top: 0px;
    border-radius: 0px;
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
</style>
