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
<script>
import Api from "@/api.js";
import * as yup from "yup";
import { Form, Field, ErrorMessage } from "vee-validate";

export default {
    components: {
        Form,
        Field,
        ErrorMessage,
    },
    emits: ["submitted"],
    data() {
        const schema = yup.object().shape({
            email: yup.string().required().email(),
            password: yup.string().required(),
        });

        const serverError = "";
        const submitting = false;

        return {
            schema,
            serverError,
            submitting,
        };
    },
    methods: {
        reset() {
            this.$refs.form.resetForm();
        },
        submit(values) {
            this.submitting = true;
            this.serverError = "";

            Api.sanctum().then((response) => {
                Api.login({
                    email: values.email,
                    password: values.password,
                })
                    .then((response) => {
                        this.$store.dispatch({
                            type: "authenticate",
                            name: response.name,
                        });

                        this.$emit("submitted");
                    })
                    .catch((error) => {
                        this.serverError = error.message;
                    })
                    .finally(() => {
                        this.submitting = false;
                    });
            });
        },
    },
};
</script>

