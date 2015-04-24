Parse.Cloud.job("getTwitterStatus", function(request, response) {
    Parse.Cloud.httpRequest({
        method: 'GET',
        url: 'https://stark-cliffs-8797.herokuapp.com/',
        success: function(httpResponse) {
            console.log(httpResponse.text);
            response.success(httpResponse.text);
        },
        error: function(httpResponse) {
            console.error('Request failed with response code ' + httpResponse.status);
            response.error('Request failed with response code ' + httpResponse.status);
        }
    });
});