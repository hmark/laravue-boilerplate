<template>
  <Form :validation-schema="schema" @submit="submit" class="row g-3">
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
      <button type="submit" class="btn btn-primary mr-auto">{{__('actions.login')}}</button>
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

    return {
      schema,
    };
  },
  methods: {
    submit(values) {
      Api.login({
        email: values.email,
        password: values.password,
        remember: !!values.remember,
      }).then((response) => {
        window.location.reload();
      });
    },
  },
};
</script>

