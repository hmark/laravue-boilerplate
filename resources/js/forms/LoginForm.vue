<template>
  <Form ref="form" :validation-schema="schema" @submit="submit" class="row g-3">
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
      <div class="form-check">
        <Field name="remember" type="checkbox" value="true" class="form-check-input"></Field>
        <label for="remember" class="form-check-label">{{__('forms.remember')}}</label>
        <ErrorMessage name="remember" />
      </div>
    </div>
    <div class="col-12">
      <button class="btn btn-primary" :disabled="submitting">
        <span v-if="submitting" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        {{__('actions.login')}}
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
      email: yup.string().required().email(),
      password: yup.string().required(),
      //   remember: yup.bool().required(),
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

      Api.login({
        email: values.email,
        password: values.password,
        remember: !!values.remember,
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

