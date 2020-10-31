/* eslint-disable indent */
import request from '@/utils/request'

/**
 * 獲取列表
 * @param {*} params
 */
export function getPageList(params = {}) {
    return request({
        url: '/page/list',
        method: 'get',
        params: params
    })
}

/**
 * 创建
 * @param {*} params
 */
export function createPage(params = {}) {
    return request({
        url: '/page/create',
        method: 'post',
        data: params
    })
}

/**
 * 更新
 * @param {*} params
 */
export function updatePage(id, params = {}) {
    return request({
        url: `/page/${id}/update`,
        method: 'post',
        data: params
    })
}

/**
 * 删除
 * @param {*} params
 */
export function deletePage(id, params = {}) {
    return request({
        url: `/page/${id}/delete`,
        method: 'post',
        data: params
    })
}
