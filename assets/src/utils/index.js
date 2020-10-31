/* eslint-disable space-before-function-paren */
import { i18n } from '@/common'
import Vue from 'vue'
import globals from '../globals'
import faker from 'faker'

/**
 * @param {*} url
 * @returns {Object}
 */
export function param2Obj(url) {
  const search = url.split('?')[1]
  if (!search) {
    return {}
  }
  return JSON.parse(
    '{"' +
    decodeURIComponent(search)
      .replace(/"/g, '\\"')
      .replace(/&/g, '","')
      .replace(/=/g, '":"')
      .replace(/\+/g, ' ') +
    '"}'
  )
}

/**
 * 頁面Title
 * @param {*} pageTitle
 */
export function getPageTitle(pageTitle) {
  const title = globals().websiteTitle
  if (pageTitle) {
    return `${i18n.t(pageTitle)} - ${i18n.t(title)}`
  }
  return `${i18n.t(pageTitle)}`
}

/**
 * 信息提示
 * @param {*} type
 * @param {*} title
 * @param {*} message
 */
export function notify(type, title, message) {
  Vue.notify({
    group: 'notifications-default',
    type: type,
    title: title,
    text: message || ''
  })
}

/**
 * generator 隨機數據
 *
 * @param {*} schema
 * @param {*} min
 * @param {*} max
 */
export function generatorFaker(schema, min = 1, max) {
  max = max || min
  return Array.from({
    length: faker.random.number({
      min,
      max
    })
  }).map(() => {
    const innerGen = (anySchema) => Object.keys(anySchema).reduce((entity, key) => {
      if (
        Object.prototype.toString.call(anySchema[key]) === '[object Object]'
      ) {
        entity[key] = innerGen(anySchema[key])
        return entity
      }

      if (anySchema[key] === '') {
        entity[key] = ''
      } else if (anySchema[key] instanceof Array) {
        entity[key] = []
      } else {
        entity[key] = faker.fake(anySchema[key])
        if (entity[key] === 'true') {
          entity[key] = true
        } else if (entity[key] === 'false') {
          entity[key] = false
        }
      }
      return entity
    }, {})

    return innerGen(schema)
  })
};
