/* eslint-disable indent */
import request from '@/utils/request'

/**
 * 选择项
 * @param {*} params
 */
export function getProfessionalItems(params = {}) {
    return request({
        url: '/professional/items',
        method: 'get',
        params: params
    })
}

/**
 * 獲取列表
 * @param {*} params
 */
export function getProfessionalList(params = {}) {
    return request({
        url: '/professional/list',
        method: 'get',
        params: params
    })
}

/**
 * 创建
 * @param {*} params
 */
export function createProfessional(params = {}) {
    return request({
        url: '/professional/create',
        method: 'post',
        data: params
    })
}

/**
 * 更新
 * @param {*} params
 */
export function updateProfessional(id, params = {}) {
    return request({
        url: `/professional/${id}/update`,
        method: 'post',
        data: params
    })
}

/**
 * 删除
 * @param {*} params
 */
export function deleteProfessional(id, params = {}) {
    return request({
        url: `/professional/${id}/delete`,
        method: 'post',
        data: params
    })
}
