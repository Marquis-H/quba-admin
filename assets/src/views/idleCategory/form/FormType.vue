<template>
  <b-form @submit.stop.prevent="onSubmit">
    <form-item
      v-for="(item, index) in formItem"
      :key="index"
      :name="index"
      :item="item"
      :value="formData[index]"
      @onchage="onChage"
      :v="$v"
    ></form-item>
  </b-form>
</template>

<script>
import { validator } from './Validator'
import { formItem } from './FormOptions'

import FormItem from './FormItem'

export default {
  name: 'form-type',
  data () {
    return {
      formItem: formItem(this.options)
    }
  },
  components: {
    FormItem
  },
  props: {
    formData: {
      type: Object
    },
    handleType: {
      type: String
    },
    options: {
      type: Object
    }
  },
  validations: validator(),
  methods: {
    onChage (v) {
      this.formData[v.name] = v.val
    },
    onSubmit () {
      this.$v.formData.$touch()
      if (!this.$v.formData.$anyError) { // 表单验证
        this.$nextTick(() => {
          this.$emit('save')
        })
      }
    }
  }
}
</script>
