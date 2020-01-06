// app/routes.js

// grab the nerd model we just created
var Record = require('./models/record');

   module.exports = function(app) {
   
       app.get('/api/show', function(req, res) {

           Record.find(function(err, records) {

               if (err)
                   res.send(err);
               console.log('The last is: \n', records[records.length-1]);
               res.json(records);
           });
       });
      //insert
       app.post('/api/insert', function(req, res) {
           var rec = new Record(req.body);
           rec.save(function(err,n){
               if (err)
                   console.log('Failed');
               console.log('saved, ID: '+ n.number + ", Message: " + n.message);
           });
       });

       // delete
       app.post('/api/delete', function(req, res){
            var id = req.body.number;
            var mess = req.body.message;
            console.log("1. The database item to be deleted is: " + id + " " + mess);
            Record.findOneAndDelete({"number": id}, function(err,n){
              if(err)
                console.log('Failed');
              console.log('deleted, ID: '+ n.number + ", Message: " + n.message);
            });
       });
       

       // update
       app.post('/api/update', function(req, res){
            var id = req.body.number;
            var mess = req.body.message;
            console.log("2. The item to be updated to is: " + id + " " + mess);
            Record.findOneAndUpdate({"number": id}, {$set: {"message" : mess}}, function(err,n){
              if(err)
                console.log('updating failed');
              console.log('updated, ID: '+ n.number + ", Message from " + n.message + " to " + mess);
            });
       });

       // search by ID 
       app.post('/api/searchByID', function(req, res){
            var id = req.body.number;
            console.log("3. The item to be searched to is: " + id );
            Record.find({"number": id}, function(err, records){
              if(err)
                res.send(err);
              console.log('Failed');
              res.json(records);
            });
       });

       // search by message content
       app.post('/api/searchByMessage', function(req, res){
            var mess = req.body.message;
            console.log("4. The item to be searched to is: " + mess );
            Record.find({"message": mess}, function(err, records){
              if(err)
                res.send(err);
              console.log('Failed');
              res.json(records);
            });
       });
       // search by message objectID
       app.post('/api/searchByObjectID', function(req, res){
           var objectID = req.body._id;
           console.log("5. The item to be searched to is: " + objectID );
           Record.find({"_id": objectID}, function(err, records){
               if(err)
                   res.send(err);
               console.log('Failed');
               res.json(records);
           });
       });

       app.get('/', function(req, res) {
           res.sendfile('./public/views/index.html'); 
       });

   };