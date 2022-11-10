import axios from 'axios'

async function callApi(method, url, data) {
    try {
        return await axios({
            method: method,
            url: url,
            data: data,
        })
    } catch (e) {
        console.log(e)
        return e.response
    }
}

export { callApi }