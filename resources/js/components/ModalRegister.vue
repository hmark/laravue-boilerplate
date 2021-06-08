<template>
  <div id="modal-register" class="modal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{__('breadcrumbs.register')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="needs-validation" novalidate>
            <div class="row g-3">
              <div class="col-12">
                <label for="name" class="form-label">{{__('forms.name')}}</label>
                <div class="input-group has-validation">
                  <input v-model="name" type="text" class="form-control" id="name" required>
                </div>
              </div>

              <div class="col-12">
                <label for="email" class="form-label">{{__('forms.email')}}</label>
                <div class="input-group has-validation">
                  <input v-model="email" type="text" class="form-control" id="email" required>
                </div>
              </div>

              <div class="col-12">
                <label for="password" class="form-label">{{__('forms.password')}}</label>
                <div class="input-group has-validation">
                  <input v-model="password" type="password" class="form-control" id="password" required>
                </div>
              </div>

              <div class="col-12">
                <label for="password_confirmation" class="form-label">{{__('forms.password_confirmation')}}</label>
                <div class="input-group has-validation">
                  <input v-model="passwordConfirmation" type="password" class="form-control" id="password_confirmation" required>
                </div>
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button @click="register()" type="button" class="btn btn-primary mr-auto">{{__('actions.register')}}</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Api from "@/api.js";

export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
    };
  },
  mounted() {
    var myModalEl = document.getElementById("modal-register");
    myModalEl.addEventListener("shown.bs.modal", function (event) {
      this.name = "";
      this.email = "";
      this.password = "";
    });
  },
  methods: {
    register() {
      Api.register({
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.password,
      }).then((response) => {
        window.location.reload();
      });
    },
  },
};
</script>

