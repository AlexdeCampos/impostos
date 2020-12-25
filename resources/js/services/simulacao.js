import axios from "axios"

function simular(data) {
    return axios.put('/api/imposto', data)
}
export default {
    simular,
}