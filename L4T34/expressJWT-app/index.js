const express = require('express');
const jwt = require('jsonwebtoken');
const bodyParser = require('body-parser');
const crypto = require('crypto');



const app = express();
const PORT = 3000;
// Generate a random secret key
const secretKey = crypto.randomBytes(32).toString('hex');

app.use(bodyParser.json());

// Mock database for storing user credentials and permissions
const users = [
  { username: 'Mazvita', password: 'mazvita123', permissions: ['/a'] },
  { username: 'Meagan', password: 'meagan123', permissions: ['/a', '/b'] },
  { username: 'Kabelo', password: 'kabelo123', permissions: ['/b', '/c'] }
];

// Login endpoint
app.post('/login', (req, res) => {
  const { username, password } = req.body;

  const user = users.find(u => u.username === username && u.password === password);

  if (!user) {
    return res.status(401).json({ message: 'Invalid username or password' });
  }

  const token = jwt.sign({ username: user.username, permissions: user.permissions }, secretKey);
  res.json({ token });
});

// Authorization middleware to check user permissions
function checkPermissions(req, res, next) {
  const authHeader = req.headers['authorization'];
  const token = authHeader && authHeader.split(' ')[1];

  if (!token) {
    return res.status(401).json({ message: 'Unauthorized' });
  }

  jwt.verify(token, secretKey, (err, user) => {
    if (err) {
      return res.status(403).json({ message: 'Forbidden' });
    }

    // Check if the user has permission to access the requested route
    const requestedRoute = req.path;
    if (!user.permissions.includes(requestedRoute)) {
      return res.status(403).json({ message: 'Forbidden: Insufficient permissions' });
    }

    req.user = user;
    next();
  });
}

// Endpoint A
app.get('/a', checkPermissions, (req, res) => {
  res.json({ message: `Hello, ${req.user.username}! You have access to endpoint A.` });
});

// Endpoint B
app.get('/b', checkPermissions, (req, res) => {
  res.json({ message: `Hello, ${req.user.username}! You have access to endpoint B.` });
});

// Endpoint C
app.get('/c', checkPermissions, (req, res) => {
  res.json({ message: `Hello, ${req.user.username}! You have access to endpoint C.` });
});

// Start the server
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
