<template>
  <b-navbar
    toggleable="lg"
    :variant="getLayoutNavbarBg()"
    class="layout-navbar align-items-lg-center container-p-x"
  >
    <!-- Brand demo (see demo.css) -->
    <b-navbar-brand to="/" class="app-brand demo d-lg-none py-0 mr-4">
      <span class="app-brand-text demo font-weight-normal ml-2">{{$t(websiteTitle)}}</span>
    </b-navbar-brand>

    <!-- Sidenav toggle (see demo.css) -->
    <b-navbar-nav
      class="layout-sidenav-toggle d-lg-none align-items-lg-center mr-auto"
      v-if="sidenavToggle"
    >
      <a class="nav-item nav-link px-0 mr-lg-4" href="javascript:void(0)" @click="toggleSidenav">
        <i class="ion ion-md-menu text-large align-middle" />
      </a>
    </b-navbar-nav>

    <b-navbar-toggle target="app-layout-navbar"></b-navbar-toggle>

    <b-collapse is-nav id="app-layout-navbar">
      <!-- Divider -->
      <hr class="d-lg-none w-100 my-2" />

      <b-navbar-nav class="align-items-lg-center ml-auto">
        <b-nav-item-dropdown :right="!isRTL" class="demo-navbar-user">
          <template slot="button-content">
            <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
              <img :src="`${baseUrl}img/avatars/1.png`" alt class="d-block ui-w-30 rounded-circle" />
              <span class="px-1 mr-lg-2 ml-2 ml-lg-0">{{ name }}</span>
            </span>
          </template>

          <b-dd-item @click="handleProfile">
            <i class="ion ion-ios-person text-lightest"></i>
            &nbsp; {{ $t("TITLE_PROFILE") }}
          </b-dd-item>
          <b-dd-divider />
          <b-dd-item @click="handleLogout">
            <i class="ion ion-ios-log-out text-danger"></i>
            &nbsp; {{ $t("TITLE_LOGOUT") }}
          </b-dd-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>

<script>
import { mapState } from 'vuex'

export default {
  name: 'app-layout-navbar',

  props: {
    sidenavToggle: {
      type: Boolean,
      default: true
    }
  },
  computed: {
    ...mapState({
      name: state => state.user.name
    })
  },
  methods: {
    toggleSidenav () {
      this.layoutHelpers.toggleCollapsed()
    },
    getLayoutNavbarBg () {
      return this.layoutNavbarBg
    },
    handleProfile () {
      this.$router.push({ name: 'Profile' })
    },
    async handleLogout () {
      await this.$store.dispatch('user/logout')
      this.$router.push(`/login?redirect=${this.$route.fullPath}`)
    }
  }
}
</script>
