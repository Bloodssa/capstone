import api from '../api/axios';

export default class InquiryMessage
{
    /**
     * 
     * @param {FormData} payload 
     * @returns 
     */
    static async post(payload)
    {
        const res = await api.post("/api/messages", payload);
        return res.data;
    }

    /**
     * 
     * @param {string} inquiryId from the window.location 
     * @returns 
     */
    static async get(inquiryId)
    {
        const res = await api.get(`/api/messages/${inquiryId}`);
        return res.data;
    }
}