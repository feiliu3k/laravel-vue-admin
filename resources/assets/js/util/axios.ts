import axios, {AxiosRequestConfig} from 'axios';


const AuthorizationHead: string = 'Bearer ';

export default (store: any, router: any) => {

    axios.defaults.validateStatus = function (status: number) {
        return (status >= 200 && status < 300) || status === 422;// default
    };
    axios.interceptors.request.use(function (config: AxiosRequestConfig):AxiosRequestConfig {
        if (store.getters.authToken) {
            config.headers.common['Authorization'] = `${AuthorizationHead}${store.getters.authToken}`;
        }
        config.headers.common['Access-Control-Allow-Methods'] = config.method;
        config.headers.common['Accept'] = 'application/json';
        config.withCredentials = true;
        return config;
    }, function (error):Promise<any> {
        return Promise.reject(error);
    });

    axios.interceptors.response.use(function (response: any) {
        let result = null;
        let token = response && response.headers && response.headers.authorization ? response.headers.authorization : null;
        if (token) {
            token = token.slice(AuthorizationHead.length);
            store.commit('SAVE_TOKEN', {
                'token': token,
                'remember': false
            });
        }
        if (response.status === 422) {
            let data:{ [key:string]:any} = {};
            console.log(response.data.errors);
            Object.keys(response.data.errors).forEach(key => {
                if (response.data.errors[key] instanceof Array) {
                    data[key] = response.data.errors[key][0];
                } else {
                    data[key] = response.data.errors[key];
                }
            });
            result = {success: false, error: data};
        } else {
            result = response.data;
        }

        return Promise.resolve(result);
    }, function (error):Promise<any> {
        if (error.response) {
            if (error.response.status === 401) {
                store.commit('LOGOUT');
                router.push('/login');
            }
        }
        return Promise.resolve({success: false});
    });
    return axios;

}