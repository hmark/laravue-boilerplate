import axios, { AxiosError } from 'axios'

export default {
    async sanctum() {
        const response = await axios.get('/sanctum/csrf-cookie').catch(this.errorHandler);
        return response?.data;
    },

    async me() {
        const response = await axios.get('/api/me').catch(this.errorHandler);
        return response?.data;
    },

    async login(data: Object) {
        const response = await axios.post('/api/login/cookie', data).catch(this.errorHandler);
        return response?.data;
    },

    async register(data: Object) {
        const response = await axios.post('/api/register', data).catch(this.errorHandler);
        return response?.data;
    },

    async logout(data?: Object) {
        const response = await axios.post('/api/logout/cookie', data).catch(this.errorHandler);
        return response?.data;
    },

    errorHandler(error: Error | AxiosError) {
        if (axios.isAxiosError(error) && error.response) {
            var errorMessage =
                [400, 403].includes(error.response.status) && error.response.data.message ?
                    error.response.data.message :
                    error.response.status + " " + error.response.statusText;

            throw new Error(errorMessage);
        }

    }
}
