import "react-datepicker/dist/react-datepicker.css";
import React, { useEffect } from "react";
import DatePicker from "react-datepicker";
import ImageUploading from "react-images-uploading";
import { Link } from "react-router-dom";
import locations from "../constants/locations";
import useAddEditCampaign from "../api/hooks/useAddEditCampaign";

const AddEditCampaign = (props) => {
    const state = useAddEditCampaign();

    useEffect(() => {
        // Update
        if (props.value) {
            state.setInitialImages([...props.value.images.map((image) => image.id)]);
            const initData = { ...props.value };
            initData.images = initData.images.map((image) => {
                image.data_url = `/images/banners/${image.image_name}`;
                return image;
            });
            state.setData(initData);
        }
    }, [props]);

    return (
        <form onSubmit={state.handleSubmit}>
            {state.errors.length > 0 && (
                <div className="alert alert-danger" role="alert">
                    <ul>
                        {state.errors.map((err, idx) => (
                            <li key={idx}>{err}</li>
                        ))}
                    </ul>
                </div>
            )}
            {state.success && (
                <div className="alert alert-success" role="alert">
                    Success
                </div>
            )}
            <div className="form-group">
                <label htmlFor="name">Name</label>
                <input
                    type="text"
                    className="form-control"
                    id="name"
                    name="name"
                    placeholder="Enter name"
                    value={state.data.name}
                    onChange={state.handleChange}
                />
            </div>
            <div className="form-group">
                <label htmlFor="daily_budget">Daily budget</label>
                <input
                    type="number"
                    name="daily_budget"
                    className="form-control"
                    id="daily_budget"
                    placeholder="Enter daily budget"
                    value={state.data.daily_budget}
                    onChange={state.handleChange}
                />
            </div>
            <div className="form-group">
                <label htmlFor="total_budget">Total budget</label>
                <input
                    type="number"
                    name="total_budget"
                    className="form-control"
                    id="total_budget"
                    placeholder="Enter total budget"
                    value={state.data.total_budget}
                    onChange={state.handleChange}
                />
            </div>
            <div className="form-group">
                <label htmlFor="date_from">From</label>
                <DatePicker
                    name={"date_from"}
                    id="date_from"
                    selected={new Date(state.data.from)}
                    className="form-control"
                    onChange={(date) => state.handleDateChange(date, "from")}
                />
            </div>
            <div className="form-group">
                <label htmlFor="date_to">To</label>
                <DatePicker
                    name={"date_to"}
                    id="date_to"
                    selected={new Date(state.data.to)}
                    className="form-control"
                    onChange={(date) => state.handleDateChange(date, "to")}
                />
            </div>
            <div className="form-group">
                <ImageUploading
                    multiple
                    value={state.data.images}
                    onChange={state.onImageChange}
                    maxNumber={10}
                    dataURLKey="data_url"
                >
                    {({
                        imageList,
                        onImageUpload,
                        onImageRemoveAll,
                        onImageRemove,
                        isDragging,
                        dragProps,
                    }) => (
                        <div className="upload__image-wrapper">
                            <button
                                type="button"
                                style={isDragging ? { color: "red" } : undefined}
                                onClick={onImageUpload}
                                {...dragProps}
                            >
                                Upload image
                            </button>
                            &nbsp;
                            <button type="button" onClick={onImageRemoveAll}>
                                Remove all images
                            </button>
                            {imageList.map((image, index) => (
                                <div key={index} className="image-item">
                                    <img src={image["data_url"]} alt="" width="100" />
                                    <div className="image-item__btn-wrapper">
                                        <button
                                            type="button"
                                            onClick={() => onImageRemove(index)}
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </ImageUploading>
            </div>
            <button type="submit" className="btn btn-primary">
                Submit
            </button>
            <Link className="btn btn-info ml-3" to={{ pathname: locations.HOME }}>
                List
            </Link>
        </form>
    );
};

export default AddEditCampaign;
