<template>
  <nav class="layout-footer footer" :class="getLayoutFooterBg()">
    <div class="container-fluid d-flex flex-wrap justify-content-between text-center container-p-x pb-3">
      <div class="pt-3">
        <span class="footer-text font-weight-bolder">{{$t(websiteTitle)}}</span> ©
      </div>
      <div>
        <a href="javascript:void(0)" class="footer-link pt-3">{{$t('TITLE_ABOUT_US')}}</a>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'app-layout-footer',

  methods: {
    getLayoutFooterBg () {
      return `bg-${this.layoutFooterBg}`
    }
  }
}
</script>
