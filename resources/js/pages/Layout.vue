<template>
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">{{__('breadcrumbs.home')}}</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav px-3 flex-row ">
      <li v-if="!config.isAuth" class="nav-item">
        <a class="nav-link mx-3" href="#" data-bs-toggle="modal" data-bs-target="#modal-login">{{__('breadcrumbs.login')}}</a>
      </li>
      <li v-if="!config.isAuth" class="nav-item">
        <a class="nav-link mx-3" href="#" data-bs-toggle="modal" data-bs-target="#modal-register">{{__('breadcrumbs.register')}}</a>
      </li>
      <li v-if="config.isAuth" class="nav-item text-nowrap">
        <a @click.prevent="logout()" class="nav-link" href="#">{{__('actions.logout')}}</a>
      </li>
    </ul>
  </header>

  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <router-link to="/" class="nav-link">
                <i class="gg-home-alt"></i>
                {{__('breadcrumbs.dashboard')}}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/page" class="nav-link">
                <span data-feather="file"></span>
                {{__('breadcrumbs.page')}}
              </router-link>
            </li>
          </ul>
        </div>
      </nav>

      <router-view></router-view>
    </div>
    <modal-register></modal-register>
    <modal-login></modal-login>
  </div>
</template>

<script>
import ModalRegister from "@/modals/ModalRegister";
import ModalLogin from "@/modals/ModalLogin";
import Api from "@/api.js";

export default {
  components: { ModalLogin, ModalRegister },

  computed: {
    config: function () {
      return window.config;
    },
  },
  methods: {
    logout() {
      Api.logout().then((response) => {
        window.location.href = "/";
      });
    },
  },
};
</script>
