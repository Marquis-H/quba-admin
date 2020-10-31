<template>
  <b-modal
    ref="userModal"
    v-on:ok="addUser"
    :no-close-on-backdrop="true"
    :no-close-on-esc="true"
    size="Large"
    :centered="true"
    cancel-title="取消"
    ok-title="保存"
  >
    <div slot="modal-title">{{ handleType === "create" ? "新增" : "编辑" }}</div>
    <form-type
      :formData="userForm"
      :handleType="handleType"
      :options="options"
      @save="onSubmit"
      ref="form"
    />
  </b-modal>
</template>

<script>
import FormType from '../form/FormType'

export default {
  name: 'form-modal',
  components: {
    FormType
  },
  props: {
    handleType: {
      type: String
    },
    userForm: {
      type: Object
    },
    options: {
      type: Object
    }
  },
  methods: {
    addUser (bvModalEvt) {
      bvModalEvt.preventDefault()
      this.$refs.form.onSubmit()
    },
    onSubmit () {
      this.$nextTick(() => {
        this.$emit('save')
      })
    }
  }
}
</script>
