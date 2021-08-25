import React, { useState } from "react";

const ImagesPreview = (props) => {
    const [isOpen, setIsOpen] = useState(false);

    const toggleDialog = (e) => {
        e.preventDefault();
        setIsOpen(!isOpen);
    };

    return (
        <div>
            <a href="#" className="btn btn-dark" onClick={toggleDialog}>
                Show images
            </a>
            {isOpen && (
                <dialog
                    className="dialog"
                    style={{ position: "absolute" }}
                    open
                    onClick={toggleDialog}
                >
                    {props.images.length ? (
                        props.images.map((image) => (
                            <img
                                key={image.id}
                                className="img-thumbnail img-fluid"
                                width="200"
                                height="200"
                                src={`/images/banners/${image.image_name}`}
                                onClick={toggleDialog}
                                alt="no image"
                            />
                        ))
                    ) : (
                        <span>No pictures</span>
                    )}
                </dialog>
            )}
        </div>
    );
};

export default ImagesPreview;
