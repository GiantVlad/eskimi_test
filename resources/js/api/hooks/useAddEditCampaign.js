import React, { useState } from "react";
import { httpClient } from "../httpClient";
import toDateString from "../../helpers/dataTime";

const useAddEditCampaign = () => {
    const [data, setData] = useState({
        id: null,
        name: "",
        daily_budget: "",
        total_budget: "",
        from: new Date(),
        to: new Date(),
        images: [],
    });
    const [initialImages, setInitialImages] = useState([]);
    const [errors, setErrors] = useState([]);
    const [success, setSuccess] = useState(false);

    const createFormData = () => {
        const formData = new FormData();
        if (data.id) {
            formData.append("id", data.id);
        }
        formData.append("name", data.name);
        formData.append("daily_budget", data.daily_budget);
        formData.append("total_budget", data.total_budget);
        formData.append("from", toDateString(data.from));
        formData.append("to", toDateString(data.to));

        let imagesToRemove = [...initialImages];
        data.images.forEach((file, idx) => {
            if (file.file) {
                formData.append(`pictures[${idx}]`, file.file);
            }
            imagesToRemove = imagesToRemove.filter((id) => !file.id || id !== file.id);
        });

        imagesToRemove.forEach((id) => {
            formData.append(`imagesToRemove[${id}]`, id);
        });
        return formData;
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        setErrors([]);
        setSuccess(false);
        const formData = createFormData();

        if (data.id) {
            if (data.images.length < 1) {
                setErrors(["Please upload picture."]);
                return;
            }
            formData.append("_method", "PUT");
            httpClient
                .post(`/campaign/${data.id}`, formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                })
                .then(() => {
                    setSuccess(true);
                })
                .catch((err) => {
                    console.log(err.response);
                    if (err.response.status && err.response.status === 422) {
                        setErrors(Object.values(err.response.data.errors));
                    } else {
                        setErrors(["Internal server error"]);
                    }
                });

            return;
        }

        httpClient
            .post("/campaign", formData, {
                headers: { "Content-Type": "multipart/form-data" },
            })
            .then(() => {
                setSuccess(true);
            })
            .catch((err) => {
                console.log(err.response);
                if (err.response.status && err.response.status === 422) {
                    setErrors(Object.values(err.response.data.errors));
                } else {
                    setErrors(["Internal server error"]);
                }
            });
    };

    const handleChange = (event) => {
        setData({ ...data, [event.target.name]: event.target.value });
    };

    const handleDateChange = (date, field) => {
        setData({ ...data, [field]: date });
    };

    const onImageChange = (images) => {
        setData({ ...data, images: images });
    };

    return {
        data,
        setData,
        initialImages,
        setInitialImages,
        handleChange,
        handleDateChange,
        onImageChange,
        errors,
        success,
        handleSubmit,
    };
};

export default useAddEditCampaign;
