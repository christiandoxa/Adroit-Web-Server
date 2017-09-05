var connection = require("./connection");
var generateToken = require("./GenerateToken");
connection.init();

function Model(){
  this.que = function(quer,body,callback){
    connection.acquire(function(err,con){
      if(err){
        console.log(err);
        return callback(err,null);
      }else{
        con.query(quer,body,function(err,data){
          con.release();
          if(err){
            return callback(err,null);
          }else if (data.length > 0) {
            return callback(null,data);
          }else{
            return callback('other',data);
          }
        });
      }
    });
  };

  this.findToken = function(token, callback) {
    process.nextTick(function() {
      connection.acquire(function(err,con){
        if(err){
          console.log(err);
          return callback(null, null);
        }else{
          con.query('SELECT token FROM akun WHERE token = ?',token,function(err,data){
            con.release();
            if(err){
              return callback(err, null);
            }else if(data.length > 0){
              if(data){
                return callback(null, data);
              }else{
                return callback(null, null);
              }
            }else{
              return callback(null, null);
            }
          });
        }
      })
    });
  };
};
module.exports = new Model();
