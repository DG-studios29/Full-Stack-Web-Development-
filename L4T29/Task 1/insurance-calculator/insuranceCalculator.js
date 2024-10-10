// insuranceCalculator.js
module.exports = {
    calculateInsuranceCost: function(kilometers) {
        if (kilometers <= 20) {
            return 200;
        } else if (kilometers <= 50) {
            return 200 + (kilometers - 20) * 1;
        } else if (kilometers <= 100) {
            return 220 + (kilometers - 50) * 0.80;
        } else {
            return 260 + (kilometers - 100) * 0.50;
        }
    }
};
