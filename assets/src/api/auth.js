import request from '@/utils/request'

/**
 * 登陆
 * @param {*} params
 */
export function login (params = {}) {
  return request({
    url: '/auth/login_check',
    method: 'post',
    data: params
  })
}

/**
 * 登出
 * @param {*} params
 */
export function logout (params = {}) {
  return request({
    url: '/auth/logout',
    method: 'post',
    params: params
  })
}
