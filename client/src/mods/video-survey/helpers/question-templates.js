const textfield = {
	field_type: 'textfield',
	content: 'Who is your favorite actor?',
	options: {
		outlined: true,
		placeholder: 'Enter your answer here...',
	},
}

const textarea = {
	field_type: 'textarea',
	content: 'What does your business do?',
	options: {
		outlined: true,
		placeholder: 'Enter your answer here...',
	},
}

const multipleChoice = {
	field_type: 'multiple-choice',
	content: 'What is your annual turnover?',
	options: {
		multiple: false,
		items: ['Under 50k', '50 - 100K', '100 - 200k', '200 - 500k', 'More than 500k'],
	},
}
const multipleChoiceMulti = {
	field_type: 'multiple-choice',
	content: 'How does your website generate leads?',
	options: {
		multiple: true,
		items: ['Phone', 'Email optin', 'Social media', 'Text message'],
	},
}

const checkbox = {
	field_type: 'checkbox',
	content: 'Recommend to others?',
	options: {
		toggle: false,
		label: 'I would recommend this product to others',
	},
}

const toggle = {
	field_type: 'checkbox',
	content: 'Does this apply to you?',
	options: {
		toggle: true,
		label: 'Yes please',
	},
}
const ab = {
	field_type: 'ab',
	content: 'Preferred contact channel?',
	options: {
		items: ['Phone', 'Text'],
	},
}

export default {
	textfield,
	textarea,
	'multiple-choice': multipleChoice,
	'multiple-choice-multi': multipleChoiceMulti,
	checkbox,
	toggle,
	ab,
}
