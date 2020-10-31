<template>
  <div id="app">
    <router-view />
    <notifications group="notifications-default" />
  </div>
</template>

<style src="@/vendor/styles/bootstrap.scss" lang="scss"></style>
<style src="@/vendor/styles/appwork.scss" lang="scss"></style>
<style src="@/vendor/styles/theme-soft.scss" lang="scss"></style>
<style src="@/vendor/styles/colors.scss" lang="scss"></style>
<style src="@/vendor/styles/uikit.scss" lang="scss"></style>
<style src="./styles/index.scss" lang="scss"></style>

<script>
export default {
  name: 'App',
  metaInfo: {
    title: 'Index',
    titleTemplate: '%s - Admin'
  }
}
</script>
