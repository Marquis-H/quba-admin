/* eslint-disable indent */
import request from '@/utils/request'

/**
 * 选择项
 * @param {*} params
 */
export function getCollegeItems(params = {}) {
    return request({
        url: '/college/items',
        method: 'get',
        params: params
    })
}

/**
 * 獲取学院列表
 * @param {*} params
 */
export function getCollegeList(params = {}) {
    return request({
        url: '/college/list',
        method: 'get',
        params: params
    })
}

/**
 * 创建学院
 * @param {*} params
 */
export function createCollege(params = {}) {
    return request({
        url: '/college/create',
        method: 'post',
        data: params
    })
}

/**
 * 更新学院
 * @param {*} params
 */
export function updateCollege(id, params = {}) {
    return request({
        url: `/college/${id}/update`,
        method: 'post',
        data: params
    })
}

/**
 * 删除学院
 * @param {*} params
 */
export function deleteCollege(id, params = {}) {
    return request({
        url: `/college/${id}/delete`,
        method: 'post',
        data: params
    })
}
