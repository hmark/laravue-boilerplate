<template>
  <div id="modal-register" class="modal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{__('breadcrumbs.register')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <RegisterForm />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import RegisterForm from "@/forms/RegisterForm";

export default {
  components: {
    RegisterForm,
  },
};
</script>

