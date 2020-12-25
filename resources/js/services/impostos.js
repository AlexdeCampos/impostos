import axios from "axios"

function list() {
    return axios.get('/api/imposto')
}

function create(data) {
    return axios.post('/api/imposto', data)
}

function deleteImposto(id) {
    return axios.delete('/api/imposto/' + id)

}
export default {
    list,
    create,
    deleteImposto
}