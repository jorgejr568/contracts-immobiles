export const InValidatorRule = (field, options) => (value) =>
    options.includes(value) ||
    `${field} needs to be in these options: ${options.join(', ')}`
