const ContractAddressLineFilter = (property) =>
    `${property.street}, ${property.number ? `${property.number},` : ''} ${
        property.city
    }, ${property.state}`

export default ContractAddressLineFilter
