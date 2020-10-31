<template>
  <b-input
    v-model="inputVal"
    :placeholder="placeholder"
    :type="type"
    :state="state"
    :disabled="disabled"
  />
</template>

<script>
export default {
  name: 'form-type',
  props: {
    value: [String, Number],
    placeholder: String,
    type: String,
    state: Boolean,
    disabled: Boolean
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
