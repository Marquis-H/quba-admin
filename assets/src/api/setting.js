import request from '@/utils/request'

/**
 * 获取设定信息
 * @param {*} params
 */
export function getSetting(params = {}) {
  return request({
    url: '/setting/info',
    method: 'get',
    params: params
  })
}

/**
 * 更新设定
 * @param {*} params
 */
export function updateSetting(params = {}) {
  return request({
    url: '/setting/update',
    method: 'post',
    data: params
  })
}
