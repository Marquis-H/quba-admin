import { login, logout } from '@/api/auth'
import { getUserInfo } from '@/api/user'
import { getToken, setToken, removeToken } from '@/utils/auth'
import { resetRouter } from '@/router'

export const types = {
  SET_TOKEN: 'set_token',
  SET_NAME: 'set_name',
  SET_ROLES: 'set_roles',
  SET_SETTING: 'set_setting'
}

const state = {
  token: getToken(),
  name: 'Marquis',
  roles: [],
  setting: {}
}
const mutations = {
  [types.SET_TOKEN](state, token) {
    state.token = token
  },
  [types.SET_NAME](state, name) {
    state.name = name
  },
  [types.SET_ROLES](state, roles) {
    state.roles = roles
  },
  [types.SET_SETTING](state, setting) {
    state.setting = setting
  }
}
const actions = {
  // 登录
  login({ commit }, userInfo) {
    const { username, password } = userInfo
    return new Promise((resolve, reject) => {
      login({ username: username.trim(), password: password }).then(response => {
        const { token } = response
        commit(types.SET_TOKEN, token) // 存Token
        setToken(token)
        resolve()
      }).catch(error => {
        reject(error)
      })
    })
  },
  // 获取当前登录的用户信息
  getInfo({ commit }) {
    return new Promise((resolve, reject) => {
      getUserInfo().then(response => {
        const { data } = response
        const { roles, name, setting } = data

        commit(types.SET_NAME, name)
        commit(types.SET_ROLES, roles) // 存权限
        commit(types.SET_SETTING, setting)
        resolve(data)
      }).catch(error => {
        reject(error)
      })
    })
  },
  // 登出
  logout({ commit, state }) {
    return new Promise((resolve, reject) => {
      logout(state.token).then(() => {
        commit(types.SET_TOKEN, '')
        commit(types.SET_ROLES, [])
        removeToken()
        resetRouter()
        resolve()
      }).catch(error => {
        reject(error)
      })
    })
  },
  // 清空Token
  resetToken({ commit }) {
    return new Promise(resolve => {
      commit(types.SET_TOKEN, '')
      commit(types.SET_ROLES, [])
      removeToken()
      resolve()
    })
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}
