<template>
    <Form ref="form" :validation-schema="schema" @submit="submit" class="row g-3">
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
            <button class="btn btn-primary w-100" :disabled="submitting">
                <span v-if="submitting" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Login
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
    email: yup.string().required().email().label("Email"),
    password: yup.string().required().label("Password"),
})
const serverError = ref('')
const submitting = ref(false)
const form = ref(null)

function reset() {
    form.value.resetForm()
}

function submit(values) {
    submitting.value = true
    serverError.value = ""

    Api.sanctum().then((response) => {
        Api.login({
            email: values.email,
            password: values.password,
        })
            .then((response) => {
                authStore.authenticate(response.name, response.admin)
                emit('submitted')
                router.push("/")
            })
            .catch((error) => {
                serverError.value = error.message
            })
            .finally(() => {
                submitting.value = false
            })
    })
}
</script>

