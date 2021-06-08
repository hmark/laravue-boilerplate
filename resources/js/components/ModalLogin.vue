<template>
  <div id="modal-login" class="modal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{__('breadcrumbs.login')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="needs-validation" novalidate>
            <div class="row g-3">
              <div class="col-12">
                <label for="email" class="form-label">{{__('forms.email')}}</label>
                <div class="input-group has-validation">
                  <input v-model="email" type="text" class="form-control" required>
                </div>
              </div>

              <div class="col-12">
                <label for="password" class="form-label">{{__('forms.password')}}</label>
                <div class="input-group has-validation">
                  <input v-model="password" type="password" class="form-control" required>
                </div>
              </div>

              <div class="col-12">
                <div class="form-check">
                  <input v-model="remember" class="form-check-input" type="checkbox" value="">
                  <label class="form-check-label">{{__('forms.remember')}}</label>
                </div>
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button @click="login()" type="button" class="btn btn-primary mr-auto">{{__('actions.login')}}</button>
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
      email: "",
      password: "",
      remember: false,
    };
  },
  mounted() {
    var myModalEl = document.getElementById("modal-login");
    myModalEl.addEventListener("shown.bs.modal", function (event) {
      this.email = "";
      this.password = "";
      this.remember = false;
    });
  },
  methods: {
    login() {
      Api.login({
        email: this.email,
        password: this.password,
        remember: this.remember,
      }).then((response) => {
        window.location.reload();
      });
    },
  },
};
</script>

