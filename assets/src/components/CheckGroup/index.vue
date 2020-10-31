<template>
  <b-check-group plain v-model="inputVal" :options="options" :state="state" />
</template>

<script>
export default {
  name: 'check-group',
  props: {
    value: Array,
    options: Array,
    state: Boolean
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
