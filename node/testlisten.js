const express = require('express');
const port = 3000;




const app = express();
app.listen(port, function () {
  console.log("Server is running on "+ port +" port");
});

app.use((req, res, next) => {
  // console.log(parseInt(req.query.idRequest));
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  res.idResponse = parseInt(jsonObj.reservoirs[0].properties.id_funceme)
  console.log(res.idResponse);
  next()
})

app.get('/', function (req, res) {
  res.send('<h1>Hello World!</h1>')
})
