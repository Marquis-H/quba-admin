<template>
  <b-form @submit.stop.prevent="handleChangePassword()">
    <b-form-group label="当前密码" :invalid-feedback="invalidOldPassword">
      <div slot="label">
        <i class="ion ion-ios-medical text-left text-danger"></i> 当前密码
      </div>
      <b-input
        type="password"
        v-model="password.old"
        :state="$v.password.old.$dirty ? !$v.password.old.$error : null"
      />
    </b-form-group>
    <b-form-group label="新密码" :invalid-feedback="invalidNewPassword">
      <div slot="label">
        <i class="ion ion-ios-medical text-left text-danger"></i> 新密码
      </div>
      <b-input
        type="password"
        v-model="password.password"
        :state="$v.password.password.$dirty ? !$v.password.password.$error : null"
      />
    </b-form-group>
    <b-form-group label="确认新密码" :invalid-feedback="invalidRepeatPassword">
      <b-input
        type="password"
        v-model="password.repeatPassword"
        :state="$v.password.repeatPassword.$dirty ? !$v.password.repeatPassword.$error:null"
      />
    </b-form-group>
    <div class="text-right mt-3">
      <b-btn variant="primary" type="submit">保存</b-btn>
    </div>
  </b-form>
</template>

<script>
import { required, minLength, sameAs } from 'vuelidate/lib/validators'

export default {
  name: 'change-password-form',
  data () {
    return {
      password: {}
    }
  },
  computed: {
    invalidOldPassword () {
      if (!this.$v.password.old.required) {
        return '必须填写'
      }
      return undefined
    },
    invalidNewPassword () {
      if (!this.$v.password.password.required) {
        return '必须填写'
      }
      if (!this.$v.password.password.minLength) {
        return '密码至少大于8位'
      }
      return undefined
    },
    invalidRepeatPassword () {
      if (!this.$v.password.repeatPassword.sameAsPassword) {
        return '密码必须相同'
      }
      return undefined
    }
  },
  validations: {
    password: {
      old: {
        required
      },
      password: {
        required,
        minLength: minLength(8)
      },
      repeatPassword: {
        sameAsPassword: sameAs('password')
      }
    }
  },
  methods: {
    handleChangePassword () {
      this.$v.password.$touch()
      if (!this.$v.password.$anyError) { // 表单验证
        this.$nextTick(() => {
          this.$emit('submit', this.password)
        })
      }
    }
  }
}
</script>
