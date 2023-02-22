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
            name: yup.string().required().min(6).max(20).label('Name'),
            email: yup.string().required().email().label('Email'),
            password: yup.string().required().min(8).label('Password'),
            password_confirmation: yup
                .string()
                .required()
                .oneOf(
                    [yup.ref("password")],
                    "Passwords do not match", { attribute: "" }
                )
                .label("Repeat Password"),
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

            Api.register({
                name: values.name,
                email: values.email,
                password: values.password,
                password_confirmation: values.password_confirmation,
            })
                .then((response) => {
                    this.$store.dispatch({
                        type: "authenticate",
                        name: values.name,
                    });

                    this.$emit("submitted");
                })
                .catch((error) => {
                    this.serverError = error.message;
                })
                .finally(() => {
                    this.submitting = false;
                });
        },
    },
};
</script>

