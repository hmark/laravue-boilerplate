<template>
    <div class="row">
        <div class="col-6 mb-5">
            <div :id="props.elementId + '-toolbar'">
                <span class="ql-formats">
                    <button class="ql-bold"></button>
                    <button class="ql-italic"></button>
                    <button class="ql-underline"></button>
                </span>
                <span class="ql-formats">
                    <!-- <button class="ql-link"></button> -->
                    <button @click.prevent="openAnchorAdder()" class="p-0 m-0" type="button"><i class="bi bi-link-45deg"></i></button>
                    <button @click.prevent="openImagePicker()" class="p-0 m-0" type="button"><i class="bi bi-card-image"></i></button>
                    <button @click.prevent="openImageUploader()" class="p-0 m-0" type="button"><i class="bi bi-upload"></i></button>

                    <button class="ql-video"></button>
                </span>
                <span class="ql-formats">
                    <button class="ql-header" value="1"></button>
                    <button class="ql-header" value="2"></button>
                    <button class="ql-header" value="3"></button>
                    <button class="ql-header" value="4"></button>
                    <button class="ql-header" value="5"></button>
                </span>
                <span class="ql-formats">
                    <button class="ql-list" value="ordered"></button>
                    <button class="ql-list" value="bullet"></button>
                </span>
                <span class="ql-formats">
                    <button class="ql-indent" value="-1"></button>
                    <button class="ql-indent" value="+1"></button>
                </span>
                <span class="ql-formats">
                    <select class="ql-align" style="display: none">
                        <option selected></option>
                        <option value="center"></option>
                        <option value="right"></option>
                        <option value="justify"></option>
                    </select>
                </span>
                <span class="ql-formats">
                    <button class="ql-clean"></button>
                </span>
            </div>
            <div :id="props.elementId" class="mb-5"></div>
        </div>
        <div class="col-6 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="main-text" v-html="modelValue"></div>
                </div>
            </div>
        </div>
    </div>
    <div v-for="error in errors" class="invalid-feedback d-block">{{ error }}</div>
    <ImagePickerModal ref="imagePicker" @pick="addImage" :width="290" :height="180" :classes="'w-100 object-fit-cover aspect290x180'" />
    <ImageUploaderModal ref="imageUploader" @on-uploaded="addImage" />
    <AnchorAdderModal ref="anchorAdder" @on-add="addAnchor" />
</template>

<script setup lang="ts">
import Quill from 'quill'
import 'quill/dist/quill.snow.css'
import { inject, nextTick, onMounted, useTemplateRef, watch } from 'vue'
import useValidators from './useValidators.js'
import ImageUploaderModal from '@/admin/modals/ImageUploaderModal.vue'
import ImagePickerModal from '@/admin/modals/ImagePickerModal.vue'
import AnchorAdderModal from '@/admin/modals/AnchorAdderModal.vue'

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    elementId: {
        type: String,
        default: 'editor',
    },
    name: {
        type: String,
        default: 'name',
    },
    placeholder: {
        type: String,
        default: 'Name',
    },
    rows: {
        type: String,
        default: '4',
    },
    rules: {
        type: String,
        default: '',
    },
})

watch(
    props,
    async () => {
        const delta = quill.clipboard.convert({ html: props.modelValue })
        quill.setContents(delta, 'silent')
    },
    { once: true }
)

const emit = defineEmits(['update:modelValue'])

const registerField: Function | undefined = inject('registerField')
const { validate, errors } = useValidators()
const imagePicker = useTemplateRef('imagePicker')
const imageUploader = useTemplateRef('imageUploader')
const anchorAdder = useTemplateRef('anchorAdder')

let quill = null
let lastSelectionIndex = 0
let lastSelectionRangeLength = 0

onMounted(() => {
    nextTick(() => {
        const isTargetBlankRegex = /\?external=true/
        const Link = Quill.import('formats/link')
        class MyLink extends Link {
            static create(value) {
                const isTargetBlank = isTargetBlankRegex.test(value)
                let node = Link.create(value)

                if (!isTargetBlank) {
                    node.removeAttribute('target')
                }

                return node
            }

            format(name, value) {
                if (name !== this.statics.blotName || !value) {
                    super.format(name, value)
                } else {
                    // @ts-expect-error
                    this.domNode.setAttribute('href', this.constructor.sanitize(value))
                }
            }
        }
        Quill.register(MyLink)

        const options = {
            // debug: 'info',
            modules: {
                toolbar: {
                    container: '#' + props.elementId + '-toolbar',
                },
            },
            placeholder: props.placeholder,
            theme: 'snow',
            bounds: props.elementId,
        }

        quill = new Quill('#' + props.elementId, options)

        quill.on('text-change', (delta, oldDelta, source) => {
            emit('update:modelValue', quill.getSemanticHTML().replaceAll(/((?:&nbsp;)*)&nbsp;/g, '$1 '))

            nextTick(() => {
                validateInput()
            })
        })
    })
})

function openImagePicker() {
    imagePicker.value.open()
}

function openImageUploader() {
    imageUploader.value.open()
}

function openAnchorAdder() {
    var range = quill.getSelection()
    lastSelectionIndex = range == null ? 0 : range.index
    lastSelectionRangeLength = range == null ? 0 : range.length

    var text = quill.getText(lastSelectionIndex, lastSelectionRangeLength)

    anchorAdder.value.open(text)
}

function addImage(image) {
    var range = quill.getSelection()
    var index = range == null ? 0 : range.index
    quill.insertEmbed(index, 'image', image.path, Quill.sources.USER)
}

function addAnchor(title, link, isTargetBlank) {
    link = link + (isTargetBlank ? '?external=true' : '')

    if (lastSelectionRangeLength > 0) {
        quill.deleteText(lastSelectionIndex, lastSelectionRangeLength)
    }

    quill.insertText(lastSelectionIndex, title, 'link', link, Quill.sources.USER)
}

function validateInput() {
    validate(props.rules, props.name, props.modelValue)

    return errors.length === 0
}

if (registerField) {
    registerField(validateInput)
}
</script>

<style>
.ql-editor {
    /* overflow-y: scroll; */
    min-height: 300px;
}

.ql-container {
    height: 95%;
}
</style>
