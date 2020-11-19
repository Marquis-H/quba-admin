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

/**
 * 删除
 * @param {*} params
 */
export function deleteIdleApplication(id, params = {}) {
    return request({
        url: `/idle_application/${id}/delete`,
        method: 'post',
        data: params
    })
}

/**
 * 置顶
 * @param {*} params
 */
export function changeTop(params = {}) {
    return request({
        url: `/idle_application/change_top`,
        method: 'post',
        data: params
    })
}
