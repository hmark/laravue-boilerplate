<template>
    <Form ref="form" :validation-schema="schema" @submit="submit" class="row g-3">
        <div class="col-12">
            <div class="input-group">
                <Field name="name" type="text" class="form-control" placeholder="Name"></Field>
                <ErrorMessage name="name" class="invalid-feedback d-block" />
            </div>
        </div>
        <div class="col-12">
            <div class="input-group">
                <Field name="email" type="email" class="form-control" placeholder="Email"></Field>
                <ErrorMessage name="email" class="invalid-feedback d-block" />
            </div>
        </div>
        <div class="col-12">
            <div class="input-group">
                <Field name="password" type="password" class="form-control" placeholder="Password"></Field>
                <ErrorMessage name="password" class="invalid-feedback d-block" />
            </div>
        </div>
        <div class="col-12">
            <div class="input-group">
                <Field name="password_confirmation" type="password" class="form-control" placeholder="Repeat Password">
                </Field>
                <ErrorMessage name="password_confirmation" class="invalid-feedback d-block" />
            </div>
        </div>
        <div class="col-12">
            <button class="btn btn-primary w-100" :disabled="submitting">
                <span v-if="submitting" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Register
            </button>
            <span v-if="serverError" role="alert" class="invalid-feedback d-block">{{ serverError }}</span>
        </div>
    </Form>
</template>
<script setup>
import { ref } from 'vue'
import Api from '@/api.js'
import * as yup from 'yup'
import { Form, Field, ErrorMessage } from 'vee-validate'
import { useAuthStore } from '@/stores/AuthStore.js'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

const emit = defineEmits(['submitted'])
defineExpose({ reset })

const schema = yup.object().shape({
    name: yup.string().required().min(6).max(20).label('Name'),
    email: yup.string().required().email().label('Email'),
    password: yup.string().required().min(8).label('Password'),
    password_confirmation: yup
        .string()
        .required()
        .oneOf([yup.ref('password')], 'Passwords must match')
        .label('Confirmed Password'),
})
const serverError = ref('')
const submitting = ref(false)
const form = ref(null)

function reset() {
    form.value.resetForm()
}

function submit(values) {
    submitting.value = true
    serverError.value = ''

    Api.register({
        name: values.name,
        email: values.email,
        password: values.password,
        password_confirmation: values.password_confirmation,
    })
        .then((response) => {
            authStore.authenticate(values.name, false)
            emit("submitted");
            router.push("/")
        })
        .catch((error) => {
            serverError.value = error.message
        })
        .finally(() => {
            submitting.value = false
        })
}
</script>

