/* eslint-disable space-before-function-paren */
/* eslint-disable indent */
import { required } from 'vuelidate/lib/validators'

export const validator = () => {
    return {
        formData: {
            title: {
                required
            },
            tabs: {
                required
            },
            endAt: {
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
        invalidTabs(t) {
            if (!t.v.formData.tabs.required) {
                return t.$t('TITLE_REQUIRED')
            }
            return undefined
        },
        invalidEndAt(t) {
            if (!t.v.formData.endAt.required) {
                return t.$t('TITLE_REQUIRED')
            }
            return undefined
        }
    }
}
