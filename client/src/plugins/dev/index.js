import devRaw from './components/Raw'
import { loadComponents } from '@/helpers/loaders'
const context = require.context('./components', true, /\.vue$/i)

export default {
	install(Vue, options) {
		loadComponents(Vue, context, 'Dev')
	},
}
