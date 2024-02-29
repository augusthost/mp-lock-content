const fs = require('fs');
// Read the JS code from the file
const filePath = './dist/mp-lock.js';
const originalCode = fs.readFileSync(filePath, 'utf8');
// Wrap the code in an IIFE
const wrappedCode = `(function(){${originalCode}})();`;
// Append the wrapped code back to the file
fs.writeFileSync(filePath, wrappedCode);