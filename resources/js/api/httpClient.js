import axios from "axios";

export const BASE_URL = "./api/v1";

export const httpClient = axios.create({
    baseURL: BASE_URL,
    withCredentials: false,
});
