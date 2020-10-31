<template>
  <div
    class="authentication-wrapper authentication-2 ui-bg-cover ui-bg-overlay-container px-4"
    :style="`background-image: url('${baseUrl}img/bg/1.jpg');`"
  >
    <div class="ui-bg-overlay bg-dark opacity-25"></div>

    <div class="authentication-inner py-5">
      <b-card no-body>
        <div class="p-4 p-sm-5">
          <!-- Logo -->
          <div class="d-flex justify-content-center align-items-center pb-2">
            <div class="ui-w-120">
              <img width="120px" src="../../assets/logo.png" />
            </div>
          </div>
          <!-- / Logo -->

          <h5 class="text-center text-muted font-weight-normal">
            有寻小程序管理系统
          </h5>
          <!-- Form -->
          <b-form @submit="onSubmit">
            <b-form-group id="username" :label="$t('TITLE_USERNAME')">
              <b-input v-model="loginForm.username" required />
            </b-form-group>
            <b-form-group id="password">
              <div
                slot="label"
                class="d-flex justify-content-between align-items-end"
              >
                <div>{{ $t("TITLE_PASSWORD") }}</div>
              </div>
              <b-input type="password" v-model="loginForm.password" required />
            </b-form-group>
            <div class="d-flex justify-content-between align-items-center m-0">
              <b-check v-model="loginForm.rememberMe" class="m-0">{{
                $t("TITLE_REMEMBER_ME")
              }}</b-check>
              <ladda-btn
                :loading="submitLoading"
                type="submit"
                class="btn btn-primary"
                data-style="expand-left"
                >{{ $t("TITLE_SIGN_IN") }}</ladda-btn
              >
            </div>
          </b-form>
          <!-- / Form -->
        </div>
      </b-card>
    </div>
  </div>
</template>
<style src="@/vendor/styles/pages/authentication.scss" lang="scss"></style>

<script>
import LaddaBtn from '@/vendor/libs/ladda/Ladda'

export default {
  name: 'login',
  metaInfo: {
    title: '登录'
  },
  components: {
    LaddaBtn
  },
  data() {
    return {
      loginForm: {
        username: '',
        password: '',
        rememberMe: false
      },
      submitLoading: false,
      redirect: undefined,
      otherQuery: {}
    }
  },
  watch: {
    $route: {
      handler: function (route) {
        const query = route.query
        if (query) {
          this.redirect = query.redirect
          this.otherQuery = this.getOtherQuery(query)
        }
      },
      immediate: true
    }
  },
  methods: {
    onSubmit(evt) {
      evt.preventDefault()
      this.submitLoading = true
      this.$store
        .dispatch('user/login', this.loginForm)
        .then(() => {
          this.$router.push({
            path: this.redirect || '/',
            query: this.otherQuery
          })
          this.submitLoading = false
        })
        .catch(() => {
          this.submitLoading = false
        })
    },
    getOtherQuery(query) {
      return Object.keys(query).reduce((acc, cur) => {
        if (cur !== 'redirect') {
          acc[cur] = query[cur]
        }
        return acc
      }, {})
    }
  }
}
</script>
