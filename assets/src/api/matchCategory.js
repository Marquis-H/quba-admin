/* eslint-disable indent */
import request from '@/utils/request'

/**
 * 选择项
 * @param {*} params
 */
export function getMatchCategoryItems(params = {}) {
    return request({
        url: '/match_category/items',
        method: 'get',
        params: params
    })
}

/**
 * 獲取列表
 * @param {*} params
 */
export function getMatchCategoryList(params = {}) {
    return request({
        url: '/match_category/list',
        method: 'get',
        params: params
    })
}

/**
 * 创建
 * @param {*} params
 */
export function createMatchCategory(params = {}) {
    return request({
        url: '/match_category/create',
        method: 'post',
        data: params
    })
}

/**
 * 更新
 * @param {*} params
 */
export function updateMatchCategory(id, params = {}) {
    return request({
        url: `/match_category/${id}/update`,
        method: 'post',
        data: params
    })
}

/**
 * 删除
 * @param {*} params
 */
export function deleteMatchCategory(id, params = {}) {
    return request({
        url: `/match_category/${id}/delete`,
        method: 'post',
        data: params
    })
}
