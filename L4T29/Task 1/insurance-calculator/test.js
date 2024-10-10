// test.js
const insuranceCalculator = require('./insuranceCalculator');

const testCases = [
    { kilometers: 10, expected: 200 },
    { kilometers: 30, expected: 210 },
    { kilometers: 75, expected: 240 },
    { kilometers: 120, expected: 270 }
];

testCases.forEach(({ kilometers, expected }) => {
    const result = insuranceCalculator.calculateInsuranceCost(kilometers);
    console.log(`Kilometers: ${kilometers}, Expected: ${expected}, Result: ${result}`);
    console.assert(result === expected, `Test failed for kilometers: ${kilometers}`);
});

console.log('All tests passed');
