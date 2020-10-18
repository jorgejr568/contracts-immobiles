export const StringSorter = (prop) => (a, b, reverse) => {
    const aProp = prop ? a[prop] : a
    const bProp = prop ? b[prop] : b

    if (reverse) return bProp.localeCompare(aProp)

    return aProp.localeCompare(bProp)
}
