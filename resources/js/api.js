import axios from 'axios'

export default {
    async login(data) {
        const response = await axios.post('/api/login', data).catch(this.errorHandler);
        return response.data;
    },

    async register(data) {
        const response = await axios.post('/api/register', data).catch(this.errorHandler);
        return response.data;
    },

    async logout(data) {
        const response = await axios.post('/api/logout', data).catch(this.errorHandler);
        return response.data;
    },

    errorHandler(error) {
        var errorMessage =
            error.response.status == 400 && error.response.data.message ?
            error.response.data.message :
            error.response.status + " " + error.response.statusText;

        throw new Error(errorMessage);
    }
}