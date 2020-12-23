/* eslint-disable space-before-function-paren */
/* eslint-disable indent */
import { invalid } from './Validator'
import store from '../../../store'

export const formData = {
    title: '',
    slug: '',
    url: '',
    file: []
}

export const formItem = (options) => {
    return {
        title: {
            label: '名称',
            placeholder: '请填写名称',
            state: true,
            invalid: invalid().invalidTitle,
            component: 'Input',
            required: true
        },
        slug: {
            label: 'Slug',
            placeholder: '请填写',
            invalid: invalid().invalidSlug,
            component: 'Input',
            state: true,
            required: true
        },
        url: {
            label: '链接',
            placeholder: '请填写',
            component: 'Input',
            state: false,
            required: false
        },
        file: {
            label: 'Banner',
            state: false,
            component: 'UploadImages',
            action: store.getters.setting.domain + '/api/v1/admin/upload/image',
            required: false
        }
    }
}
