import request from '@/utils/request'

/**
 * 获取Dashboard信息
 * @param {*} params
 */
export function getDashboardInfo (params = {}) {
  return request({
    url: '/dashboard/info',
    method: 'get',
    params: params
  })
}
