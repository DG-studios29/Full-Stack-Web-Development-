// delete_file.js
const fs = require('fs');

module.exports = function deleteFile(fileName) {
    fs.unlink(fileName, err => {
        if (err) {
            console.error('Error deleting file:', err);
        } else {
            console.log('File deleted successfully.');
        }
    });
};
