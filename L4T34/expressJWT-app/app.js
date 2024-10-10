const express = require('express');
const jwt = require('jsonwebtoken');
const bodyParser = require('body-parser');

const app = express();
const PORT = 3000;

// Sample users data with route access permissions
const users = [
    { username: 'Mazvita', password: 'password', permissions: ['/a'] },
    { username: 'Meagan', password: 'password', permissions: ['/a', '/b'] },
    { username: 'Kabelo', password: 'password', permissions: ['/b', '/c'] }
];

// Secret key for JWT
const secretKey = 'your_secret_key'; // Change this to a secure secret key

// Middleware to parse JSON body
app.use(bodyParser.json());

// Login endpoint
app.post('/login', (req, res) => {
    const { username, password } = req.body;

    // Find user in the users array
    const user = users.find(u => u.username === username && u.password === password);
    if (!user) {
        return res.status(401).json({ message: 'Invalid username or password' });
    }

    // Generate JWT token with user's permissions
    const token = jwt.sign({ username: user.username, permissions: user.permissions }, secretKey);
    res.json({ token });
});

// Middleware to verify JWT
const verifyToken = (req, res, next) => {
    const token = req.headers['authorization'];
    if (!token) {
        return res.status(401).json({ message: 'Token not provided' });
    }

    jwt.verify(token.split(' ')[1], secretKey, (err, decoded) => {
        if (err) {
            return res.status(403).json({ message: 'Failed to authenticate token' });
        }
        req.user = decoded;
        next();
    });
};

// Endpoint for route /a
app.get('/a', verifyToken, (req, res) => {
    const userPermissions = req.user.permissions;
    if (userPermissions.includes('/a')) {
        res.json({ message: 'Access granted to route /a' });
    } else {
        res.status(403).json({ message: 'Unauthorized access' });
    }
});

// Endpoint for route /b
app.get('/b', verifyToken, (req, res) => {
    const userPermissions = req.user.permissions;
    if (userPermissions.includes('/b')) {
        res.json({ message: 'Access granted to route /b' });
    } else {
        res.status(403).json({ message: 'Unauthorized access' });
    }
});

// Endpoint for route /c
app.get('/c', verifyToken, (req, res) => {
    const userPermissions = req.user.permissions;
    if (userPermissions.includes('/c')) {
        res.json({ message: 'Access granted to route /c' });
    } else {
        res.status(403).json({ message: 'Unauthorized access' });
    }
});

// Start server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
