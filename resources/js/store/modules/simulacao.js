import simulacaoService from "../../services/simulacao"

const state = { dataSimulacao: {}, simulacaoMessage: "" }

const actions = {
    async simularImposto({ commit }, simulacao) {
        try {
            const { data } = await simulacaoService.simular(simulacao)
            commit('setDataSimulacao', data.data)
            commit('setMessage', data.message)
        } catch (error) {
            throw commit('setMessage', error.response.data.message)
        }
    }
}

const mutations = {
    setDataSimulacao(state, payload) {
        state.dataSimulacao = payload
    },
    setMessage(state, payload) {
        state.simulacaoMessage = payload
    }
}

export default { namespaced: true, state, actions, mutations }