import cookiesServices from "../services/cookiesServices.js";

const apiServices = {

    headerContent: {
        'Content-Type': 'application/json; charset=utf-8',
    },

    mediaHeaderContent: {
        'Content-Type': 'multipart/form-data',
    },

    authHeaderContent: () => ({
        'Content-Type': 'application/json; charset=utf-8',
        'Authorization': `Bearer ${cookiesServices.get('access_token') || ''}`
    }),

    authHeaderMediaContent: () => ({
        'Content-Type': 'multipart/form-data',
        'Authorization': `Bearer ${cookiesServices.get('access_token') || ''}`
    })

}

export default apiServices;
