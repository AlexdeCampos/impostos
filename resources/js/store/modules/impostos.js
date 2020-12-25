import impostoService from "../../services/impostos"

const state = { impostoList: [], impostoMessage: "" }

const actions = {
    async fetchListaImposto({ commit }) {
        const { data } = await impostoService.list()
        commit('setImpostoList', data)

    },
    async setImposto({ commit }, imposto) {
        try {
            const { data } = await impostoService.create(imposto)
            commit('updateImpostoList', data.data)
            commit('setMessage', data.message)
        } catch (error) {
            throw commit('setMessage', error.response.data.message)
        }
    },
    async deleteImposto({ commit }, id) {
        try {
            const { data } = await impostoService.deleteImposto(id)
            console.log(data)
            commit('deleteImposto', id)
            commit('setMessage', data.message)
        } catch (error) {
            throw commit('setMessage', error.response.data.message)
        }
    }
}

const mutations = {
    setImpostoList(state, payload) {
        state.impostoList = payload
    },
    updateImpostoList(state, payload) {
        state.impostoList.push(payload)
    },
    setMessage(state, payload) {
        state.impostoMessage = payload
    },
    deleteImposto(state, payload) {
        state.impostoList = state.impostoList.filter((imposto) => imposto.id !== payload)
    }
}

export default { namespaced: true, state, actions, mutations }