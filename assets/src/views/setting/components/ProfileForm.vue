<template>
  <b-form @submit.stop.prevent="handleSaveProfile()">
    <b-form-group>
      <label class="switcher">
        <input type="checkbox" class="switcher-input" v-model="accountData.isEnable" />
        <span class="switcher-indicator">
          <span class="switcher-yes"></span>
          <span class="switcher-no"></span>
        </span>
        <span class="switcher-label">是否开启</span>
      </label>
    </b-form-group>
    <b-form-group label="用户名" :invalid-feedback="invalidUsername">
      <div slot="label">
        <i class="ion ion-ios-medical text-left text-danger"></i> 用户名
      </div>
      <b-input
        v-model="accountData.username"
        :state="$v.accountData.username.$dirty ? !$v.accountData.username.$error : null"
      />
    </b-form-group>
    <b-form-group label="电邮">
      <b-input v-model="accountData.email" />
      <!-- <b-input
        v-model="accountData.email"
        :state="$v.accountData.email.$dirty ? !$v.accountData.email.$error : null"
      />-->
    </b-form-group>
    <b-form-group label="姓名" :invalid-feedback="invalidName">
      <div slot="label">
        <i class="ion ion-ios-medical text-left text-danger"></i> 姓名
      </div>
      <b-input
        v-model="accountData.name"
        :state="$v.accountData.name.$dirty ? !$v.accountData.name.$error : null"
      />
    </b-form-group>
    <div class="text-right mt-3">
      <b-btn variant="primary" type="submit">保存</b-btn>
    </div>
  </b-form>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css" ></style>
<style src="@/vendor/libs/vue-multiselect/vue-multiselect.scss" lang="scss"></style>
<script>
import { required } from 'vuelidate/lib/validators'
// import Multiselect from 'vue-multiselect'

export default {
  name: 'profile-form',
  components: {
    // Multiselect
  },
  computed: {
    invalidUsername () {
      if (!this.$v.accountData.username.required) {
        return '必须填写'
      }
      return undefined
    },
    invalidName() {
      if (!this.$v.accountData.name.required) {
        return '必须填写'
      }
      return undefined
    }
    // invalidEmail () {
    //   if (!this.$v.accountData.email.required) {
    //     return '必须填写'
    //   }
    //   if (!this.$v.accountData.email.email) {
    //     return '邮箱地址无效'
    //   }
    //   return undefined
    // }
  },
  data () {
    return {
      languageOptions: [
        { label: '繁體', value: 'zh_TW' },
        { label: '简体', value: 'zh_CN' },
        { label: '英文', value: 'en' },
        { label: '葡文', value: 'pt_PT' }
      ]
    }
  },
  props: {
    accountData: {
      type: Object
    }
  },
  validations: {
    accountData: {
      username: {
        required
      },
      name: {
        required
      }
    }
  },
  methods: {
    handleSaveProfile () {
      this.$v.accountData.$touch()
      if (!this.$v.accountData.$anyError) { // 表单验证
        this.$nextTick(() => {
          this.$emit('submit', this.accountData)
        })
      }
    }
  }
}
</script>
