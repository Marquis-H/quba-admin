<template>
  <b-form-textarea
    rows="6"
    v-model="inputVal"
    :placeholder="placeholder"
    :type="type"
    :state="state"
  />
</template>

<script>
export default {
  name: 'form-type',
  props: {
    value: String,
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
