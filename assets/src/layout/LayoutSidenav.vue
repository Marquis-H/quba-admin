<template>
  <sidenav :orientation="orientation" :class="curClasses">
    <!-- Brand demo (see src/demo.css) -->
    <div class="app-brand demo" v-if="orientation !== 'horizontal'">
      <span class="app-brand-logo demo" style="overflow: initial">
        <img width="80px" src="../assets/logo.png" />
      </span>
      <router-link
        to="/"
        class="app-brand-text demo sidenav-text font-weight-normal ml-2"
        >{{ $t(websiteTitle) }}</router-link
      >
      <a
        href="javascript:void(0)"
        class="layout-sidenav-toggle sidenav-link text-large ml-auto"
        @click="toggleSidenav()"
      >
        <i class="ion ion-md-menu align-middle"></i>
      </a>
    </div>
    <div class="sidenav-divider mt-0" v-if="orientation !== 'horizontal'"></div>

    <!-- Links -->
    <div
      class="sidenav-inner"
      :class="{ 'py-1': orientation !== 'horizontal' }"
    >
      <layout-sidenav-item
        v-for="route in permission_routes"
        :key="route.path"
        :item="route"
        :base-path="route.path"
      />
    </div>
  </sidenav>
</template>

<script>
import { Sidenav } from '@/vendor/libs/sidenav'
import LayoutSidenavItem from './LayoutSidenavItem'
import { mapGetters } from 'vuex'

export default {
  name: 'app-layout-sidenav',
  components: {
    Sidenav,
    LayoutSidenavItem
  },

  props: {
    orientation: {
      type: String,
      default: 'vertical'
    }
  },

  computed: {
    ...mapGetters([
      'permission_routes'
    ]),
    curClasses () {
      let bg = this.layoutSidenavBg

      if (this.orientation === 'horizontal' && (bg.indexOf(' sidenav-dark') !== -1 || bg.indexOf(' sidenav-light') !== -1)) {
        bg = bg
          .replace(' sidenav-dark', '')
          .replace(' sidenav-light', '')
          .replace('-darker', '')
          .replace('-dark', '')
      }

      return `bg-${bg} ` + (
        this.orientation !== 'horizontal'
          ? 'layout-sidenav'
          : 'layout-sidenav-horizontal container-p-x flex-grow-0'
      )
    }
  },

  methods: {
    isMenuActive (url) {
      return this.$route.path.indexOf(url) === 0
    },

    isMenuOpen (url) {
      return this.$route.path.indexOf(url) === 0 && this.orientation !== 'horizontal'
    },

    toggleSidenav () {
      this.layoutHelpers.toggleCollapsed()
    }
  }
}
</script>
