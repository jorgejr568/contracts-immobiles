export const SizeValidatorRule = (field, size, parser) => (value) => {
    value = value?.toString() || ''
    if (typeof parser === 'function') value = parser(value)
    return value.length === size || `${field} needs to be size ${size}`
}
