import React, { useState } from "react";
import { httpClient } from "../httpClient";

const useGetCampaigns = () => {
    const [campaigns, setCampaigns] = useState([]);
    const [currentPage, setCurrentPage] = useState(1);

    const fetch = async (page) => {
        try {
            const res = await httpClient.get(`/campaigns`, { params: { page } });
            setCampaigns(res.data.data);
            setCurrentPage(res.data.meta.current_page);
        } catch (err) {
            console.log(err);
        }
    };

    const nextPage = (e) => {
        e.preventDefault();
        fetch(campaigns.length > 0 ? currentPage + 1 : currentPage);
    };

    const prevPage = (e) => {
        e.preventDefault();
        fetch(currentPage < 2 ? 1 : currentPage - 1);
    };

    return { campaigns, currentPage, fetch, nextPage, prevPage };
};

export default useGetCampaigns;
