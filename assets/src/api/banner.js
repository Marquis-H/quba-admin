/* eslint-disable indent */
import request from '@/utils/request'

/**
 * 獲取列表
 * @param {*} params
 */
export function getBannerList(params = {}) {
    return request({
        url: '/banner/list',
        method: 'get',
        params: params
    })
}

/**
 * 创建
 * @param {*} params
 */
export function createBanner(params = {}) {
    return request({
        url: '/banner/create',
        method: 'post',
        data: params
    })
}

/**
 * 更新
 * @param {*} params
 */
export function updateBanner(id, params = {}) {
    return request({
        url: `/banner/${id}/update`,
        method: 'post',
        data: params
    })
}

/**
 * 删除
 * @param {*} params
 */
export function deleteBanner(id, params = {}) {
    return request({
        url: `/banner/${id}/delete`,
        method: 'post',
        data: params
    })
}
