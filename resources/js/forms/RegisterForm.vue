<template>
  <Form :validation-schema="schema" @submit="submit" class="row g-3">
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
      <button type="submit" class="btn btn-primary mr-auto">{{__('actions.register')}}</button>
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
      name: yup.string().required().min(6),
      email: yup.string().required().email(),
      password: yup.string().required().min(8),
      password_confirmation: yup.string().oneOf(
        [yup.ref("password"), null],
        this.__("validation.confirmed", {
          attribute: this.__("forms.password"),
        })
      ),
    });

    return {
      schema,
    };
  },
  methods: {
    submit(values) {
      console.log(values);
      Api.register({
        name: values.name,
        email: values.email,
        password: values.password,
        password_confirmation: values.password_confirmation,
      }).then((response) => {
        window.location.reload();
      });
    },
  },
};
</script>

