<template>
  <b-select
    v-model="inputVal"
    :placeholder="placeholder"
    :type="type"
    :state="state"
    :options="options"
  />
</template>

<script>
export default {
  name: 'form-type',
  props: {
    value: [String, Number],
    options: Array,
    placeholder: String,
    type: String,
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
