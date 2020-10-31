import Vue from 'vue'
import axios from 'axios'
import store from '@/store'
import router from '../router'
import { getToken } from '@/utils/auth'

// create an axios instance
const service = axios.create({
  baseURL: process.env.VUE_APP_BASE_API, // url = base url + request url
  // withCredentials: true, // send cookies when cross-domain requests
  timeout: 5000 // request timeout
})

// request interceptor
service.interceptors.request.use(
  config => {
    // do something before request is sent

    if (store.getters.token) {
      // let each request carry token
      // ['X-Token'] is a custom headers key
      // please modify it according to the actual situation
      config.headers['Authorization'] = `Bearer ${getToken()}`
    }
    return config
  },
  error => {
    // do something with request error
    console.log(error) // for debug
    return Promise.reject(error)
  }
)

service.interceptors.response.use(
  response => {
    const res = response.data

    // if the custom code is not 20000, it is judged as an error.
    if (res.code && res.code !== 0) {
      // error code: -1
      Vue.notify({
        group: 'notifications-default',
        type: 'bg-danger text-white',
        title: 'Error',
        text: res.message
      })

      // 50008: Illegal token; 50012: Other clients logged in; 50014: Token expired;
      if (res.code === 50008 || res.code === 50012 || res.code === 50014) {
        // to re-login
        Vue.swal({
          title: 'Confirm logout',
          text: 'You have been logged out, you can cancel to stay on this page, or log in again',
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: this.$t('TITLE_CONFIRM'),
          cancelButtonText: this.$t('TITLE_CANCEL'),
          confirmButtonColor: '#1cbb84',
          allowOutsideClick: false
        }).then((result) => {
          if (result.value) {
            store.dispatch('user/resetToken').then(() => {
              location.reload()
            })
          }
        })
        store.dispatch('user/resetToken').then(() => {
          location.reload()
        })
      }
      return Promise.reject(new Error(res.message || 'Error'))
    } else {
      return res
    }
  },
  error => {
    const status = error.response.status
    if (status === 401 || status === 403) {
      router.push({
        path: '/login'
      })
    }
    Vue.notify({
      group: 'notifications-default',
      type: 'bg-danger text-white',
      title: 'Error',
      text: error.message
    })
    return Promise.reject(error)
  }
)

export default service
