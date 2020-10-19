import { cnpj, cpf } from 'cpf-cnpj-validator'
import { CONTRACT_DOCUMENT_TYPE_PERSON } from '../const/contracts-document-type'

export const CPFValidatorRule = (field) => (value) =>
    cpf.isValid(value) || `${field} needs to be a valid cpf`

export const CNPJValidatorRule = (field) => (value) =>
    cnpj.isValid(value) || `${field} needs to be a valid cnpj`

export const DocumentValidatorRule = (field, document_type) =>
    document_type === CONTRACT_DOCUMENT_TYPE_PERSON
        ? CPFValidatorRule(field)
        : CNPJValidatorRule(field)
