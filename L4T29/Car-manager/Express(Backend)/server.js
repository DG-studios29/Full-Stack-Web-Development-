const express = require('express');
const app = express();
const cors = require('cors');
const bodyParser = require('body-parser');
const helmet = require('helmet'); // Import Helmet

app.use(helmet()); // Use Helmet to secure the app
app.use(bodyParser.json());
app.use(cors());


let cars = [
  { id: 1, make: 'Mercedes-Benz', model: 'A-class', seats: 5 },
  { id: 2, make: 'Land Rover', model: 'Defender 90', seats: 6 },
];

// GET all cars
app.get('/api', (req, res) => {
  try {
    res.json(cars);
  } catch (error) {
    res.status(500).json({ error: 'Internal server error' });
  }
});

// POST a new car
app.post('/api', (req, res) => {
  try {
    const newCar = req.body;
    const newId = cars.length > 0 ? cars[cars.length - 1].id + 1 : 1; // Generate a new ID
    const carWithId = { id: newId, ...newCar };
    cars.push(carWithId);
    res.status(201).json(carWithId);
  } catch (error) {
    res.status(400).json({ error: 'Invalid request' });
  }
});

// DELETE a car by ID
app.delete('/api/:id', (req, res) => {
  try {
    const id = parseInt(req.params.id);
    const index = cars.findIndex((car) => car.id === id);
    if (index === -1) {
      return res.status(404).json({ error: 'Car not found' });
    }
    cars.splice(index, 1);
    res.sendStatus(204);
  } catch (error) {
    res.status(500).json({ error: 'Internal server error' });
  }
});

// PUT update a car by ID
app.put('/api/:id', (req, res) => {
  try {
    const id = parseInt(req.params.id);
    const updatedCar = req.body;
    const index = cars.findIndex((car) => car.id === id);
    if (index === -1) {
      return res.status(404).json({ error: 'Car not found' });
    }
    cars[index] = { ...cars[index], ...updatedCar };
    res.json(cars[index]);
  } catch (error) {
    res.status(500).json({ error: 'Internal server error' });
  }
});

const PORT = process.env.PORT || 8080;
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
