const toDateString = (date) => {
    return date instanceof Date ? date.toISOString().slice(0, 10) : date;
};

export default toDateString;
