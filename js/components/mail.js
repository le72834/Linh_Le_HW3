// async and await enable promise-based behavior to be written in a cleaner style.

async function SendMail(targetForm) {
    // mail stuff goes here
    let formData = new FormData(targetForm);

    // TODO: examine the method and incrementally build out the fetch call. currently it assumes POST

    let result = await fetch(`${targetForm.getAttribute("action")}`, {
        method: targetForm.method,
        // TODO: a GET request doesn't use body, so this member should be conditional
        body: formData,
    }).then(response => {
        if (response.status !== 200) {
            throw new Error(`Mail submission failed: ${response.status}`);

            // could examine status code here and return it as part of an error object to the .catch handler in the SendMail then-able chain in main.js
        }

        return response;
    })

    let mailStatus = await result.json();

    return mailStatus;
}

export { SendMail };