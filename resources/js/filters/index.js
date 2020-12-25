import currency from './currency'
import percent from './percent'
import states from './states'

export default {
    install: (Vue) => {
        Vue.filter('currency', currency)
        Vue.filter('percent', percent)
        Vue.filter('states', states)
    }
}