<template>
    <Form :on-validated="submit" class="row g-3">
        <div class="col-12">
            <InputField
                v-model="user.email"
                type="email"
                name="email"
                placeholder="Email"
                rules="required|email"
            />
        </div>

        <div class="col-12">
            <InputField
                v-model="user.password"
                type="password"
                name="password"
                placeholder="Password"
                rules="required"
            />
        </div>

        <template #submit="slotProps">
            <div class="col-12">
                <button
                    class="btn btn-primary w-100"
                    :disabled="slotProps.submitting"
                >
                    <span
                        v-if="slotProps.submitting"
                        class="spinner-border spinner-border-sm"
                        role="status"
                        aria-hidden="true"
                    ></span>
                    Login
                </button>
            </div>
            <div v-if="error" class="invalid-feedback d-block">{{ error }}</div>
        </template>
    </Form>
</template>
<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { Form, InputField } from '@/components/form/FormComponents'
import { useAuthStore } from '@/stores/AuthStore'
import Api from '@/api'

const authStore = useAuthStore()
const router = useRouter()
const user = reactive({
    email: '',
    password: '',
})
const error = ref(null)

async function submit() {
    error.value = null

    await Api.sanctum().then(async (response) => {
        await Api.login(user)
            .then(async (response) => {
                authStore.authenticate(
                    response.id,
                    response.name,
                    response.admin
                )
                router.push('/')
            })
            .catch(async (errorMessage) => {
                error.value = errorMessage
            })
    })
}
</script>
