import axios from 'axios'

const callApi = async (method, url, data) => {
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

const validateEmail = (email) => {
    const re = /\S+@\S+\.\S+/;
    return re.test(email);
}

export { callApi, validateEmail}