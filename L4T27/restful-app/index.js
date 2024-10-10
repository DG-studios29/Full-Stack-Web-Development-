const express = require('express');
const app = express();
const bodyParser = require('body-parser');

app.use(bodyParser.json());

let cars = [
  { id: 1, make: "Mercedes-Benz", model: "A-class", seats: 5 },
  { id: 2, make: "Land Rover", model: "Defender 90", seats: 6 }
];

// GET all cars
app.get('/api', (req, res) => {
  res.json(cars);
});

// POST a new car
app.post('/api', (req, res) => {
  const newCar = req.body;
  cars.push(newCar);
  res.status(201).json(newCar);
});

// DELETE a car by ID
app.delete('/api/:id', (req, res) => {
  const id = parseInt(req.params.id);
  cars = cars.filter(car => car.id !== id);
  res.sendStatus(204);
});

// PUT update a car by ID
app.put('/api/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const updatedCar = req.body;

  cars = cars.map(car => {
    if (car.id === id) {
      return { ...car, ...updatedCar };
    }
    return car;
  });

  res.json(cars.find(car => car.id === id));
});

const PORT = 8080;
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
