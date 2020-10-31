import request from '@/utils/request'

/**
 * 获取当前用户信息
 * @param {*} params
 */
export function getUserInfo(params = {}) {
  return request({
    url: '/user/info',
    method: 'get',
    params: params
  })
}

/**
 * 权限选择项
 * @param {*} params
 */
export function getRoles(params) {
  return request({
    url: '/user/roles',
    method: 'get',
    params: params
  })
}

/**
 * 獲取用戶信息
 * @param {*} params
 */
export function getProfile(params = {}) {
  return request({
    url: '/profile/info',
    method: 'get',
    params: params
  })
}

/**
 * 更新个人资料
 * @param {*} params
 */
export function updateProfile(params = {}) {
  return request({
    url: '/profile/update',
    method: 'post',
    data: params
  })
}

/**
 * 更新密码
 * @param {*} params
 */
export function updatePassword(params = {}) {
  return request({
    url: '/profile/change_password',
    method: 'post',
    data: params
  })
}

/**
 * 獲取管理員用戶列表
 * @param {*} params
 */
export function getUserList(params = {}) {
  return request({
    url: '/user/list',
    method: 'get',
    params: params
  })
}

/**
 * 创建管理員用戶
 * @param {*} params
 */
export function createUser(params = {}) {
  return request({
    url: '/user/create',
    method: 'post',
    data: params
  })
}

/**
 * 更新管理員用戶
 * @param {*} params
 */
export function updateUser(id, params = {}) {
  return request({
    url: `/user/${id}/update`,
    method: 'post',
    data: params
  })
}

/**
 * 删除管理員用戶
 * @param {*} params
 */
export function deleteUser(id, params = {}) {
  return request({
    url: `/user/${id}/delete`,
    method: 'post',
    data: params
  })
}
