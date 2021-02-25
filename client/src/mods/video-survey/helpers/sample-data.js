const uuidv4 = require('uuid/v4')

import qItems from './question-templates'

let k
const questions = []

const itemsMap = (items) => {
	return items.map((text) => {
		const id = uuidv4()
		return {
			text,
			id,
		}
	})
}

for (k in qItems) questions.push({ ...qItems[k], id: uuidv4() })

questions.map((a) => {
	if (a.options.items) a.options.items = itemsMap(a.options.items)
	return a
})

export default {
	questions,
}
