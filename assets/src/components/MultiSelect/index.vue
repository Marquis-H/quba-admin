<template>
  <multiselect
    v-model="inputVal"
    :options="options.map(item => item.value)"
    :multiple="true"
    :placeholder="placeholder"
    :custom-label="opt => options.find(x => x.value == opt).text"
  />
</template>

<script>
import Multiselect from 'vue-multiselect'

export default {
  name: 'form-type',
  props: {
    value: Array,
    options: Array,
    placeholder: String,
    type: String,
    state: Boolean
  },
  components: {
    Multiselect
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

<style src="vue-multiselect/dist/vue-multiselect.min.css" />
<style src="@/vendor/libs/vue-multiselect/vue-multiselect.scss" lang="scss"></style>
