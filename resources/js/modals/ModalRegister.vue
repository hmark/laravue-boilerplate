<template>
  <div ref="modal" id="modal-register" class="modal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{__('breadcrumbs.register')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <RegisterForm ref="form" @submitted="close" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { Modal } from "bootstrap";
import RegisterForm from "@/forms/RegisterForm";

export default {
  components: {
    RegisterForm,
  },
  data() {
    const modal = null;

    return {
      modal,
    };
  },
  mounted() {
    this.modal = new Modal(this.$refs.modal);
    this.$refs.modal.addEventListener("shown.bs.modal", () => {
      this.$refs.form.reset();
    });
  },
  methods: {
    close() {
      this.modal.hide();
    },
  },
};
</script>

