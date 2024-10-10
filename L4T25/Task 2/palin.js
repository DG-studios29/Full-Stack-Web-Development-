// palin.js
module.exports = function findPalindromes() {
    const palindromes = [];
    for (let i = 1; i <= 1000; i++) {
        const numStr = i.toString();
        if (numStr === numStr.split('').reverse().join('')) {
            palindromes.push(i);
        }
    }
    return palindromes;
};
