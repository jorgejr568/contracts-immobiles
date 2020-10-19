export const RequiredValidatorRule = (field) => (value) =>
    !!value || `${field} needs to be filled`
