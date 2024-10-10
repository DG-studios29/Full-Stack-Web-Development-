// Importing required modules
const http = require('http');

// Creating a web server
const server = http.createServer((req, res) => {
    // Setting the response header
    res.writeHead(200, {'Content-Type': 'text/html'});

    // Sending the response
    res.end('<h1>Hey! I can use Node!</h1>');
});

// Listening for HTTP requests on port 3000
const PORT = 3000;
server.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
