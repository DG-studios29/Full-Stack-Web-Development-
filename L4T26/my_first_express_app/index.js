const express = require('express');
const fs = require('fs');

const app = express();
const port = 3000;

app.use(express.static('public'));

// Read organisations data from JSON file
app.get('/', (req, res) => {
    fs.readFile('organisations.json', 'utf8', (err, data) => {
        if (err) {
            console.error(err);
            res.status(500).send('Internal Server Error');
            return;
        }
        const organisations = JSON.parse(data);
        let html = '<h1>Organisation listing</h1>';
        html += '<table border="1"><tr><th>Name</th><th>Email</th><th>Pty Ltd</th></tr>';
        organisations.forEach(org => {
            html += `<tr><td>${org.name}</td><td>${org.email}</td><td>${org.pty_ltd}</td></tr>`;
        });
        html += '</table>';
        res.send(html);
    });
});

// Serve terms of service HTML file
app.get('/terms_of_service.html', (req, res) => {
    res.sendFile(__dirname + '/public/terms_of_service.html');
});

// Serve privacy policy HTML file
app.get('/privacy_policy.html', (req, res) => {
    res.sendFile(__dirname + '/public/privacy_policy.html');
});

// Handle unknown paths
app.use((req, res) => {
    res.status(404).send('Sorry! Can’t find that resource. Please check your URL');
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
