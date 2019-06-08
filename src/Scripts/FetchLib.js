const baseUrl = "http://messenger/";
export default {
    fetch: function CreateFetch(url, body, callback) {
        var options = {
            method: "POST",
            mode: "cors",
            credentials: "include",
            body: body
        };
        var prom = fetch(baseUrl+url, options)
            .then(function (response) {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Network response was not ok.');
            })
            .then(callback)
            .catch(error => console.error(error));
        return prom;
    }
}