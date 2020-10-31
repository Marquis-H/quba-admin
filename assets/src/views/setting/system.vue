<template>
  <div>
    <h4 class="font-weight-bold py-2 mb-3">设定</h4>
    <b-tabs class="nav-tabs-top mb-4">
      <b-tab title="系统设定" active>
        <div class="card-body">
          <b-card-body>
            <b-form @submit.stop.prevent="handleSave('system')">
              <b-form-group label="系统名称">
                <b-input v-model="setting.system.name" />
              </b-form-group>
              <b-form-group label="LOGO">
                <single-upload-file
                  :action="$store.getters.setting.uploadImageUrl"
                  v-model="setting.system.logo"
                />
              </b-form-group>
              <div class="text-right mt-3">
                <b-btn variant="primary" type="submit">保存</b-btn>
              </div>
            </b-form>
          </b-card-body>
        </div>
      </b-tab>
      <b-tab title="一般设定">
        <div class="card-body">
          <b-card-body>
            <b-form @submit.stop.prevent="handleSave('normal')">
              <b-form-group label="Debug">
                <v-jsoneditor
                  v-model="setting.normal.debug"
                  :plus="false"
                  height="400px"
                  @error="onError"
                />
              </b-form-group>
              <div class="text-right mt-3">
                <b-btn variant="primary" type="submit">保存</b-btn>
              </div>
            </b-form>
          </b-card-body>
        </div>
      </b-tab>
    </b-tabs>
  </div>
</template>

<script>
import SingleUploadFile from '../../components/SingleUploadFile'
import { getSetting, updateSetting } from '@/api/setting'
import { notify } from '@/utils'
import VJsoneditor from 'v-jsoneditor'

const defaultSettings = require('../../settings.js')

export default {
  components: {
    SingleUploadFile,
    VJsoneditor
  },
  data () {
    return {
      setting: {
        system: {
          name: undefined,
          logo: undefined
        },
        normal: {
          isGray: false
        }
      }
    }
  },
  created () {
    this.getSetting()
  },
  methods: {
    getSetting () {
      getSetting()
        .then(res => {
          this.setting = res.data
        })
        .catch(err => {
          console.log(err)
        })
    },
    handleSave (slug) {
      updateSetting(this.setting[slug])
        .then(res => {
          notify(defaultSettings.successAlert, 'Success', '更新成功')
        })
        .catch(err => {
          console.log(err)
        })
    },
    onError () {
      console.log('error')
    }
  }
}
</script>

<style lang="scss" scoped>
</style>
