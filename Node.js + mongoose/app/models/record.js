// app/models/record.js
// grab the mongoose module
var mongoose = require('mongoose');

// define our record model
// module.exports allows us to pass this to other files when it is called
module.exports = mongoose.model('Record', {
    number : {type :String, default: ''}, 
    message : {type : String, default: ''}
});