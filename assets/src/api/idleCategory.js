/* eslint-disable indent */
import request from '@/utils/request'

/**
 * 选择项
 * @param {*} params
 */
export function getIdleCategoryItems(params = {}) {
    return request({
        url: '/idle_category/items',
        method: 'get',
        params: params
    })
}

/**
 * 獲取列表
 * @param {*} params
 */
export function getIdleCategoryList(params = {}) {
    return request({
        url: '/idle_category/list',
        method: 'get',
        params: params
    })
}

/**
 * 创建
 * @param {*} params
 */
export function createIdleCategory(params = {}) {
    return request({
        url: '/idle_category/create',
        method: 'post',
        data: params
    })
}

/**
 * 更新
 * @param {*} params
 */
export function updateIdleCategory(id, params = {}) {
    return request({
        url: `/idle_category/${id}/update`,
        method: 'post',
        data: params
    })
}

/**
 * 删除
 * @param {*} params
 */
export function deleteIdleCategory(id, params = {}) {
    return request({
        url: `/idle_category/${id}/delete`,
        method: 'post',
        data: params
    })
}
