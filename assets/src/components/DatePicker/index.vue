<template>
  <datepicker
    v-model="inputVal"
    :bootstrapStyling="true"
    :required="state"
    :input-class="state === false?'is-invalid':''"
    :wrapper-class="state === false?'error':''"
    :format="customFormatter"
    :language="zh"
    clear-button
    clear-button-icon="fa fa-times"
  />
</template>

<script>
import Datepicker from 'vuejs-datepicker'
import { zh } from 'vuejs-datepicker/dist/locale'
import moment from 'moment'

export default {
  name: 'form-type',
  components: {
    Datepicker
  },
  props: {
    value: [String, Date],
    type: String,
    state: Boolean
  },
  computed: {
    inputVal: {
      get () {
        return this.value
      },
      set (val) {
        this.$emit('onchage', moment(val).format('YYYY-MM-DD'))
      }
    }
  },
  data() {
    return {
      zh: zh
    }
  },
  methods: {
    customFormatter(date) {
      return moment(date).format('YYYY-MM-DD')
    }
  }
}
</script>

<style>
.vdp-datepicker.error ~ .invalid-feedback{
    display: inline;
}
</style>
