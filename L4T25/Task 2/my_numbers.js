// my_numbers.js
const fs = require('fs');
const http = require('http');
const palin = require('./palin');
const div7 = require('./div7');
const deleteFile = require('./delete_file');

const palindromes = palin();
const divisibleBy7 = div7();

const content = `Palindromes: ${palindromes.join(', ')}\n\nDiv7s: ${divisibleBy7.join(', ')}`;

fs.writeFile('nums.txt', content, err => {
    if (err) {
        console.error('Error creating file:', err);
    } else {
        console.log('File created successfully.');
        http.createServer(function(req, res) {
            fs.readFile('nums.txt', function(err, data) {
                res.writeHead(200, {'Content-Type': 'text/plain'});
                res.write(data);
                res.end();
            });
        }).listen(8000, 'localhost');
        console.log('Server running at http://localhost:8000/');
        deleteFile('nums.txt');
    }
});
