export const snakeToCamel = (str, startCap = false) => {
  str = str.replace(/_([a-z])/g, function(g) {
    return g[1].toUpperCase()
  })
  if (startCap) return str.charAt(0).toUpperCase() + str.slice(1)
  return str
}

export const toCamel = (str, startCap = false) => {
  if (str.indexOf('_') > -1) return snakeToCamel(str, startCap)
  str = str.replace(/-([a-z])/g, function(g) {
    return g[1].toUpperCase()
  })
  if (startCap) return str.charAt(0).toUpperCase() + str.slice(1)
  return str
}
