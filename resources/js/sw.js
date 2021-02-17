self.addEventListener('install', function(event) {});
self.addEventListener('fetch', function(event) {
    return fetch(event.request).then(
        function(response) {
            if (response.status === 419) {
                //console.error('XSRF Token expired');
            }
            return response;
        }
    )
});
