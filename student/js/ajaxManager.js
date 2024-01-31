class AJAXManager {
    constructor() {
        this.apiUrl = 'src/controllers/getController.php'; // Example API endpoint
    }

    fetchData(endpoint, successCallback, errorCallback) {
        $.ajax({
            url: `${this.apiUrl}?${endpoint}`,
            method: 'GET',
            dataType: 'json',
            success: successCallback,
            error: errorCallback
        });
    }
}