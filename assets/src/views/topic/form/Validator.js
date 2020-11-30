/* eslint-disable space-before-function-paren */
/* eslint-disable indent */
import { required } from 'vuelidate/lib/validators'

export const validator = () => {
    return {
        formData: {
            title: {
                required
            },
            content: {
                required
            },
            category: {
                required
            }
        }
    }
}

export const invalid = () => {
    return {
        invalidTitle(t) {
            if (!t.v.formData.title.required) {
                return t.$t('TITLE_REQUIRED')
            }
            return undefined
        },
        invalidContent(t) {
            if (!t.v.formData.content.required) {
                return t.$t('TITLE_REQUIRED')
            }
            return undefined
        },
        invalidCategory(t) {
            if (!t.v.formData.category.required) {
                return t.$t('TITLE_REQUIRED')
            }
            return undefined
        }
    }
}
