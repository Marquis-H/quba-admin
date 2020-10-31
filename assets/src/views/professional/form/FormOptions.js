/* eslint-disable space-before-function-paren */
/* eslint-disable indent */
import { invalid } from './Validator'

export const formData = {
    title: '',
    description: '',
    college: null
}

export const formItem = (options) => {
    let newOptions = JSON.parse(JSON.stringify(options))
    return {
        title: {
            label: '名称',
            placeholder: '请填写名称',
            state: true,
            invalid: invalid().invalidTitle,
            component: 'Input',
            required: true
        },
        description: {
            label: '说明',
            placeholder: '请填写说明',
            component: 'Textarea',
            state: false
        },
        college: {
            label: '学院',
            placeholder: '请选择学院',
            invalid: invalid().invalidCollege,
            state: true,
            options: newOptions['colleges'],
            component: 'Select',
            required: true
        }
    }
}
