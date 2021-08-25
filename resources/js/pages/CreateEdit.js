import CreateUpdateCampaign from "../components/AddEditCampaign";
import React from "react";

function CreateEdit(props) {
    return (
        <div className="container">
            <CreateUpdateCampaign value={props.location.propsData} />
        </div>
    );
}

export default CreateEdit;
