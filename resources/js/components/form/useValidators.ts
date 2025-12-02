import { reactive } from 'vue'

export default function useValidators() {
    const validators = {
        required: (fieldName: any, fieldValue?: any) => {
            return (fieldValue && !fieldValue.toString().trim()) || !fieldValue ? 'Položka ' + fieldName + ' je povinná.' : ''
        },
        min: (fieldName: string, fieldValue: string, parameters: string[]) => {
            const min = +parameters[0]
            return fieldValue && fieldValue.length < min ? `Položka ${fieldName} musí mať aspoň ${min} znakov` : ''
        },
        max: (fieldName: string, fieldValue: string, parameters: string[]) => {
            const max = +parameters[0]
            return fieldValue && fieldValue.length > max ? `Položka ${fieldName} môže mať maximálne ${max} znakov` : ''
        },
        email: (fieldName: string, fieldValue: string, parameters: string[]) => {
            let re =
                /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            return !re.test(fieldValue) ? 'Položka ' + fieldName + ' neobsahuje valídnu ' + fieldName + ' adresu' : ''
        },
        numeric: (fieldName: string, fieldValue: string, parameters: string[]) => {
            let isNum = /^\d+$/.test(fieldValue)
            return !isNum ? 'Položka ' + fieldName + ' môže obsahovať iba číslice' : ''
        },
    }

    const errors: string[] = reactive([])

    function validate(rulesString: string, name: string, value: any) {
        errors.length = 0

        if (rulesString.length > 0) {
            let rules = rulesString.split('|')

            for (let i = 0; i < rules.length; i++) {
                const parts = rules[i].split(':')
                const rule = parts[0]
                const parameters = parts.length > 1 ? parts[1].split(',') : []

                if (rule in validators) {
                    type ValidatorObjectType = keyof typeof validators
                    const error = validators[rule as ValidatorObjectType](name, value, parameters)

                    if (error) {
                        errors.push(error)
                    }
                } else {
                    console.log('ValidatorError: Unknown validation rule "' + rule + '".')
                }
            }
        }
    }

    return { validate, errors }
}
