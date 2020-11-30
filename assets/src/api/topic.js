/* eslint-disable indent */
import request from '@/utils/request'

/**
 * 獲取列表
 * @param {*} params
 */
export function getTopicList(params = {}) {
    return request({
        url: '/topic/list',
        method: 'get',
        params: params
    })
}

/**
 * 创建
 * @param {*} params
 */
export function createTopic(params = {}) {
    return request({
        url: '/topic/create',
        method: 'post',
        data: params
    })
}

/**
 * 更新
 * @param {*} params
 */
export function updateTopic(id, params = {}) {
    return request({
        url: `/topic/${id}/update`,
        method: 'post',
        data: params
    })
}

/**
 * 删除
 * @param {*} params
 */
export function deleteTopic(id, params = {}) {
    return request({
        url: `/topic/${id}/delete`,
        method: 'post',
        data: params
    })
}
