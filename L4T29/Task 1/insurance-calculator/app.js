// app.js
const express = require('express');
const bodyParser = require('body-parser');
const helmet = require('helmet');
const insuranceCalculator = require('./insuranceCalculator');

const app = express();
const port = 3000;

app.use(helmet()); // Use helmet to secure the app by setting various HTTP headers
app.use(bodyParser.json());

app.post('/calculate-insurance', (req, res) => {
    const { fleet } = req.body;

    if (!Array.isArray(fleet) || fleet.some(km => typeof km !== 'number')) {
        return res.status(400).send('Invalid input');
    }

    const totalCost = fleet.reduce((total, km) => {
        return total + insuranceCalculator.calculateInsuranceCost(km);
    }, 0);

    res.json({ totalCost });
});

app.listen(port, () => {
    console.log(`Insurance calculator app listening at http://localhost:${port}`);
});
