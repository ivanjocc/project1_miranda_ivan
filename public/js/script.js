// Function to confirm removal of an item from the cart
function confirmRemoval() {
    return confirm('Are you sure you want to remove this item from the cart?');
}

function fetchData() {
    var resultElement = document.getElementById('result');

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'https://api.example.com/data', true);

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            // If the request is successful, update the result element
            resultElement.textContent = xhr.responseText;
        } else {
            // If the request fails, display an error message
            resultElement.textContent = 'Error fetching data';
        }
    };

    xhr.send();
}

document.getElementById('myButton').addEventListener('click', function () {
    alert('Button clicked!');
});

