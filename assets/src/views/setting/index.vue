<template>
  <div>
    <b-card no-body>
      <div class="row no-gutters row-bordered row-border-light" style="overflow: initial;">
        <div class="col-md-3 pt-0">
          <b-list-group class="account-settings-links" flush>
            <b-list-group-item
              button
              :active="curTab === 'general'"
              @click="curTab = 'general'"
            >資料修改</b-list-group-item>
            <b-list-group-item
              button
              :active="curTab === 'password'"
              @click="curTab = 'password'"
            >修改密碼</b-list-group-item>
          </b-list-group>
        </div>
        <div class="col-md-9" v-if="curTab === 'general'">
          <b-card-body>
            <profile-form :accountData="accountData" @submit="this.handleSaveProfile"></profile-form>
          </b-card-body>
        </div>
        <div class="col-md-9" v-if="curTab === 'password'">
          <b-card-body class="pb-2">
            <change-password-form @submit="this.handleChangePassword"></change-password-form>
          </b-card-body>
        </div>
      </div>
    </b-card>
  </div>
</template>

<script>
import { getProfile, updateProfile, updatePassword } from '@/api/user'
import ProfileForm from './components/ProfileForm'
import ChangePasswordForm from './components/ChangePasswordForm'
import { notify } from '@/utils'
const defaultSettings = require('../../settings.js')

export default {
  data () {
    return {
      curTab: 'general',
      accountData: {}
    }
  },
  components: {
    ProfileForm,
    ChangePasswordForm
  },
  created () {
    this.getProfile()
  },
  methods: {
    getProfile () {
      var that = this
      getProfile().then(res => {
        that.accountData = res.data
      }).catch(err => {
        console.log(err)
      })
    },
    handleChangePassword (passwordData) {
      updatePassword(passwordData).then(res => {
        notify(defaultSettings.successAlert, 'Success', '更新成功')
      }).catch(err => {
        console.log(err)
      })
    },
    handleSaveProfile (accountData) {
      updateProfile(accountData).then(res => {
        notify(defaultSettings.successAlert, 'Success', '更新成功')
      }).catch(err => {
        console.log(err)
      })
    }
  }
}
</script>
