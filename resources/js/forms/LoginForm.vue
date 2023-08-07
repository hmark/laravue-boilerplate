<template>
    <Form :on-validated="submit" class="row g-3">
        <div class="col-12">
            <InputField v-model="user.email" type="email" name="email" placeholder="Email" rules="required|email" />
        </div>

        <div class="col-12">
            <InputField v-model="user.password" type="password" name="password" placeholder="Password" rules="required" />
        </div>

        <template #submit="slotProps">
            <div class="col-12">
                <button class="btn btn-primary w-100" :disabled="slotProps.submitting">Login</button>
            </div>
        </template>
    </Form>
</template>
<script setup lang="ts">
import { reactive } from 'vue'
import { useRouter } from 'vue-router'
import InputField from '@/validation/InputField.vue'
import Form from '@/validation/Form.vue'
import { useAuthStore } from '@/stores/AuthStore'
import Api from '@/api'

const authStore = useAuthStore()
const router = useRouter()
const user = reactive({
    email: '',
    password: ''
})

async function submit() {
    // await promiseTimeout(2000)
    await Api.sanctum().then(async (response) => {
        await Api.login({
            email: user.email,
            password: user.password,
        })
            .then(async (response) => {
                authStore.authenticate(response.id, response.name, response.admin)
                router.push("/")
            })
    })
}
</script>

