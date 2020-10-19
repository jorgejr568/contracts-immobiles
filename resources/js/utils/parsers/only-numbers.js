export const onlyNumbersParser = (string) =>
    string.match(/\d+/g)?.join('') || ''
