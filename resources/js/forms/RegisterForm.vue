<template>
  <Form ref="form" :validation-schema="schema" @submit="submit" class="row g-3">
    <div class="col-12">
      <label for="email" class="form-label">{{__('forms.name')}}</label>
      <div class="input-group">
        <Field name="name" type="text" class="form-control"></Field>
        <ErrorMessage name="name" class="invalid-feedback d-block" />
      </div>
    </div>
    <div class="col-12">
      <label for="email" class="form-label">{{__('forms.email')}}</label>
      <div class="input-group">
        <Field name="email" type="email" class="form-control"></Field>
        <ErrorMessage name="email" class="invalid-feedback d-block" />
      </div>
    </div>
    <div class="col-12">
      <label for="password" class="form-label">{{__('forms.password')}}</label>
      <div class="input-group">
        <Field name="password" type="password" class="form-control"></Field>
        <ErrorMessage name="password" class="invalid-feedback d-block" />
      </div>
    </div>
    <div class="col-12">
      <label for="password_confirmation" class="form-label">{{__('forms.password_confirmation')}}</label>
      <div class="input-group">
        <Field name="password_confirmation" type="password" class="form-control"></Field>
        <ErrorMessage name="password_confirmation" class="invalid-feedback d-block" />
      </div>
    </div>
    <div class="col-12">
      <button class="btn btn-primary" :disabled="submitting">
        <span v-if="submitting" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        {{__('actions.register')}}
      </button>
      <span v-if="serverError" role="alert" class="invalid-feedback d-block">{{serverError}}</span>
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
  data() {
    const schema = yup.object().shape({
      name: yup.string().required().min(6).max(20).label(this.__("forms.name")),
      email: yup.string().required().email().label(this.__("forms.email")),
      password: yup.string().required().min(8).label(this.__("forms.password")),
      password_confirmation: yup
        .string()
        .required()
        .oneOf(
          [yup.ref("password")],
          this.__("validation.confirmed", { attribute: "" })
        )
        .label(this.__("forms.password_confirmation")),
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
          window.location.reload();
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

