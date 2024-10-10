// div7.js
module.exports = function findDivisibleBy7() {
    const divBy7 = [];
    for (let i = 1; i <= 100; i++) {
        if (i % 7 === 0) {
            divBy7.push(i);
        }
    }
    return divBy7;
};
