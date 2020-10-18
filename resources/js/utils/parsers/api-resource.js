import { ApiBodyParser } from './api-body'

export const ApiResourceParser = (response) => ApiBodyParser(response)?.data
