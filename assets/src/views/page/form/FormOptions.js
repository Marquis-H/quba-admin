/* eslint-disable space-before-function-paren */
/* eslint-disable indent */
import { invalid } from './Validator'

export const formData = {
    title: '',
    slug: '',
    content: null
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
        content: {
            label: '内容',
            placeholder: '请填写内容',
            state: false,
            component: 'Editor',
            required: false
        }
    }
}
