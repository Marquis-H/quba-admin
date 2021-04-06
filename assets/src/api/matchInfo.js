/* eslint-disable indent */
import request from '@/utils/request'

/**
 * 獲取列表
 * @param {*} params
 */
export function getMatchInfoList(params = {}) {
    return request({
        url: '/match_info/list',
        method: 'get',
        params: params
    })
}

/**
 * 创建
 * @param {*} params
 */
export function createMatchInfo(params = {}) {
    return request({
        url: '/match_info/create',
        method: 'post',
        data: params
    })
}

/**
 * 更新
 * @param {*} params
 */
export function updateMatchInfo(id, params = {}) {
    return request({
        url: `/match_info/${id}/update`,
        method: 'post',
        data: params
    })
}

/**
 * 删除
 * @param {*} params
 */
export function deleteMatchInfo(id, params = {}) {
    return request({
        url: `/match_info/${id}/delete`,
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
        url: `/match_info/change_top`,
        method: 'post',
        data: params
    })
}

/**
 * 导出
 * @param {*} params
 */
export function exportData(params = {}) {
    return request({
        url: `/match_info/export`,
        method: 'post',
        data: params
    })
}
