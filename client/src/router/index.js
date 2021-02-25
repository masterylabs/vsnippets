import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../pages/Home'
import Surveys from '../pages/surveys/Surveys'
import Survey from '../pages/surveys/Survey'
import Respondents from '../pages/respondents/Respondents'
import Respondent from '../pages/respondents/Respondent'
import Settings from '../pages/settings/Settings'
// import TestPage from '../pages/TestPage'

Vue.use(VueRouter)

const routes = [
	{
		path: '/',
		name: 'home',
		component: Home,
	},
	{
		path: '/surveys',
		name: 'surveys',
		component: Surveys,
	},
	{
		path: '/surveys/:id',
		name: 'survey',
		component: Survey,
	},
	{
		path: '/respondents',
		name: 'respondents',
		component: Respondents,
	},
	{
		path: '/respondents/:id',
		name: 'respondent',
		component: Respondent,
	},
	{
		path: '/settings',
		name: 'settings',
		component: Settings,
	},
]

const router = new VueRouter({
	routes,
})

export default router
