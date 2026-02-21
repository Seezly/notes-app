export const formData = (form) => {
    const data = new FormData(form);
    const obj = {};

    for (let [key, value] of data.entries()) {
        obj[key] = value;
    }
    return obj;
};

export const getTags = async () => {
    let call = await fetch("/api/tags");
    let res = await call.json();
    let data = res.data.tags;

    return data;
};
