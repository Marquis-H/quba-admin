/* eslint-disable indent */
import request from '@/utils/request'

/**
 * 獲取列表
 * @param {*} params
 */
export function getIdleApplicationList(params = {}) {
    return request({
        url: '/idle_application/list',
        method: 'get',
        params: params
    })
}
