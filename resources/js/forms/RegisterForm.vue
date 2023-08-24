<template>
    <Form :on-validated="submit" class="row g-3">
        <div class="col-12">
            <InputField v-model="user.name" type="text" name="name" placeholder="Name" rules="required|min:6|max:20" />
        </div>

        <div class="col-12">
            <InputField v-model="user.email" type="email" name="email" placeholder="Email" rules="required|email" />
        </div>

        <div class="col-12">
            <InputField v-model="user.password" type="password" name="password" placeholder="Password" rules="required|min:8" />
        </div>

        <div class="col-12">
            <InputField v-model="user.password_confirmation" type="password" name="password_confirmation" placeholder="Repeat Password" rules="required|min:8" />
        </div>

        <template #submit="slotProps">
            <div class="col-12">
                <button class="btn btn-primary w-100" :disabled="slotProps.submitting">
                    <span v-if="slotProps.submitting" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Register
                </button>
            </div>
            <div v-if="error" class="invalid-feedback d-block">{{ error }}</div>
        </template>

    </Form>
</template>
<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { Form, InputField } from 'vue-valid-forms'
import { useAuthStore } from '@/stores/AuthStore'
import Api from '@/api'

const authStore = useAuthStore()
const router = useRouter()
const user = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})
const error = ref(null)

async function submit() {
    error.value = null

    await Api.sanctum().then(async (response) => {
        await Api.register(user)
            .then(async (response) => {
                authStore.authenticate(response.id, response.name, false)
                router.push("/")
            })
            .catch(async (errorMessage) => {
                error.value = errorMessage
            })
    })
}
</script>

