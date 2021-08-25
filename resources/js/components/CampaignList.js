import React, { useEffect } from "react";
import ImagesPreview from "./ImagesPreview";
import { Link } from "react-router-dom";
import locations from "../constants/locations";
import useGetCampaigns from "../api/hooks/useCampaigns";

const CampaignList = () => {
    const state = useGetCampaigns();

    useEffect(() => {
        state.fetch();
    }, []);

    return (
        <div>
            <Link
                className="btn btn-info mb-3"
                to={{
                    pathname: locations.CREATE,
                }}
            >
                Create
            </Link>
            <table className="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">From</th>
                        <th scope="col">To</th>
                        <th scope="col">Daily budget</th>
                        <th scope="col">Total budget</th>
                        <th scope="col">Banners</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {state.campaigns.map((campaign) => (
                        <tr key={campaign.id}>
                            <td scope="row">{campaign.id}</td>
                            <td>{campaign.name}</td>
                            <td>{campaign.from}</td>
                            <td>{campaign.to}</td>
                            <td>{campaign.daily_budget}</td>
                            <td>{campaign.total_budget}</td>
                            <td>
                                <ImagesPreview images={campaign.images} isOpen={false} />
                            </td>
                            <td>
                                <Link
                                    to={{
                                        pathname: locations.EDIT,
                                        propsData: campaign,
                                    }}
                                >
                                    <span className="oi oi-pencil" />
                                </Link>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
            <div>
                <a href="#" onClick={state.prevPage} className="mr-2">
                    <span className="oi oi-chevron-left" />
                </a>
                <a href="#" onClick={state.nextPage} className="ml-2">
                    <span className="oi oi-chevron-right" />
                </a>
            </div>
        </div>
    );
};

export default CampaignList;
