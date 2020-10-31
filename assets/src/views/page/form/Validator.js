/* eslint-disable space-before-function-paren */
/* eslint-disable indent */
import { required } from 'vuelidate/lib/validators'

export const validator = () => {
    return {
        formData: {
            title: {
                required
            },
            slug: {
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
        invalidSlug(t) {
            if (!t.v.formData.slug.required) {
                return t.$t('TITLE_REQUIRED')
            }
            return undefined
        }
    }
}
