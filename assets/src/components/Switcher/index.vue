<template>
  <label class="switcher">
    <input type="checkbox" class="switcher-input" v-model="inputVal" />
    <span class="switcher-indicator">
      <span class="switcher-yes"></span>
      <span class="switcher-no"></span>
    </span>
  </label>
</template>

<script>
export default {
  name: 'switcher',
  props: {
    value: Boolean
  },
  computed: {
    inputVal: {
      get () {
        return this.value
      },
      set (val) {
        this.$emit('onchage', val)
      }
    }
  }
}
</script>
