import { cnpj, cpf } from 'cpf-cnpj-validator'
import { CONTRACT_DOCUMENT_TYPE_ENTITY } from '../const/contracts-document-type'

export const CPFFilter = (value) => cpf.format(value)
export const CNPJFilter = (value) => cnpj.format(value)

export const DocumentFilter = (type) =>
    type === CONTRACT_DOCUMENT_TYPE_ENTITY ? CNPJFilter : CPFFilter
