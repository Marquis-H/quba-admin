/* eslint-disable indent */
import request from '@/utils/request'

/**
 * 获取小程序用户列表
 * @param {*} params
 */
export function getWeappUserList(params = {}) {
    return request({
        url: '/weapp_user/list',
        method: 'get',
        params: params
    })
}
