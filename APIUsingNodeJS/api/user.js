var db = require("../database/model");
var dbCon = require("../database/connection");
var hashToSHA1 = require("sha1");
var generateToken = require("../database/GenerateToken");
var async = require('async');
var dateFormat = require('dateformat');
var base64_encode = function(val){
  var encode = null;
  if(val){
    encode = new Buffer(val).toString('base64');
  }
  return encode;
};
var base64_decode = function(val){
  var decode = null;
  if(val){
    decode = new Buffer(val,'base64').toString('ascii');
  }
  return decode;
}
const SUCCESS = true;
const FAIL = false;

function API(){
  this.getDevice = function(req,res){
    var id_device = req.params.id;
    if(id_device){
      db.que('SELECT * FROM device WHERE device_id = ?',id_device,function(err,data){
        if(err){
          res.status(400).json({status:FAIL,result:err});
        }else{
          res.status(200).json({status:SUCCESS,result:data[0]});
        }
      });
    }else{
      res.status(400).json({status:FAIL,result:'params not found'});
    }
  };

  this.loginAwal = function(req,res){
    var email = base64_decode(req.body.email);
    var pass = base64_decode(req.body.password);
    if(email && pass){
      db.que('SELECT * FROM akun WHERE email = ? AND kata_sandi = ?',[email,hashToSHA1(pass)],function(err,data){
        if(err){
          res.status(400).json({status:FAIL,result:err});
        }else{
          res.status(200).json({status:SUCCESS,result:{token:data[0].token}});
        }
      });
    }else{
      res.status(400).json({status:FAIL,result:'params not found'});
    }
  };

  this.login = function(req,res){
    res.status(200).json({status:SUCCESS});
  };

  this.withGmail = function(req,res){
    var email = base64_decode(req.body.email);
    var nama = base64_decode(req.body.name);
    var password = generateToken.getPass();

    if(email && nama){
      async.waterfall([
        function(callback){
          db.que('SELECT * FROM akun WHERE email = ?',email,function(err,data){
            if(err){
              if(err=='other'){
                callback(null,true,null);
              }else{
                callback(err,null,null);
              }
            }else{
              callback(null,null,data[0].token);
            }
          });
        },
        function(insert,dataToken,callback){
          if(insert){
            var tok = generateToken.getToken(email,password);
            db.que('INSERT INTO akun (email,nama,kata_sandi,token) VALUES (?,?,?,?)',[email,nama,password,tok],function(err,data){
              if(err){
                if(data.affectedRows > 0){
                  callback(null,SUCCESS,tok);
                }else{
                  callback(err,null,null);
                }
              }else{
                callback(null,SUCCESS,tok);
              }
            });
          }else{
            callback(null,SUCCESS,dataToken);
          }
        }
      ],function(err,success,resultToken){
        if(err){
          res.status(400).json({status:FAIL,result:err});
        }else{
          res.status(200).json({status:SUCCESS,result:resultToken});
        }
      });
    }else{
      res.status(400).json({status:FAIL,result:'params not found'});
    }
  };

  this.updateDevice = function(req,res){
    var id = req.body.id;
    var job = req.body.job;
    var sql = null;
    if(id && job){
      switch (job) {
        case "angkat":
          sql = "servo = 'Angkat'";
          break;
        case "jemur":
          sql = "servo = 'Jemur'";
          break;
        case "On":
          sql = "status = 'On'";
          break;
        case "Off":
          sql = "status = 'Off', servo = 'Angkat', auto = 'Manual'";
          break;
        case "Manual":
          sql = "auto = 'Manual'";
          break;
        case "Otomatis":
          sql = "auto = 'Otomatis'";
          break;
      }

      if(sql){
        db.que("UPDATE device SET "+sql+"WHERE device_id = ?",id,function(err,data){
          if(err){
            if(err == 'other'){
              res.status(200).json({status:SUCCESS});
            }else{
              res.status(400).json({status:FAIL,result:err});
            }
          }else{
            res.status(200).json({status:SUCCESS});
          }
        });
      }else{
        res.status(400).json({status:FAIL,result:'params not found'});
      }
    }else{
      res.status(400).json({status:FAIL,result:'params not found'});
    }
  };

  this.signUp = function(req,res){
    var email = base64_decode(req.body.email);
    var nama = base64_decode(req.body.name);
    var password = hashToSHA1(base64_decode(req.body.password));
    if(email && nama && password){
      var tok = generateToken.getToken(email,base64_decode(req.body.password));
      db.que('INSERT INTO akun (email,nama,kata_sandi,token) VALUES (?,?,?,?)',[email,nama,password,tok],function(err,data){
        if(err){
          if(err == 'other'){
            res.status(200).json({status:SUCCESS});
          }else{
            res.status(400).json({status:FAIL,result:err});
          }
        }else{
          res.status(200).json({status:SUCCESS});
        }
      });
    }else{
      res.status(400).json({status:FAIL,result:'params not found'});
    }
  };

  this.jemuranGet = function(req,res){
    var tok = req.headers.authorization;
    var token = tok.substring(7,tok.length);
    async.waterfall([
      function(callback){
        db.que('SELECT * FROM akun WHERE token = ?',token,function(err,data){
          if(err){
            callback(err,null);
          }else{
            callback(err,data[0].email);
          }
        });
      },
      function(email,callback){
        db.que('SELECT * FROM jemur WHERE email = ?',email,function(err,data){
          if(err){
            callback(err,null);
          }else{
            callback(null,data);
          }
        });
      }
    ],function(err,data){
      if(err){
        res.status(400).json({status:FAIL,result:err});
      }else{
        res.status(200).json({status:SUCCESS,result:data});
      }
    });
  };

  this.jemuranPost = function(req,res){
    var tok = req.headers.authorization;
    var token = tok.substring(7,tok.length);
    var date = new Date(req.body.date);
    var tglJemur = dateFormat(date,"dddd, dd mmmm yyyy");
    var time = "13";
    var id_device = req.body.id;
    var id_jemuran = dateFormat(date,"ssMMHHddmmyyyy");
    async.waterfall([
      function(callback){
        db.que("SELECT email FROM akun WHERE token = ?",token,function(err,data){
          if(err){
            callback(err,null);
          }else{
            callback(null,data[0].email);
          }
        });
      },
      function(email,callback){
        db.que("INSERT INTO jemur (id_jemuran,device_id,tanggal_jemur,estimasi_waktu,email) VALUES (?,?,?,?,?)",[id_jemuran,id_device,tglJemur,time,email],function(err,data){
          if(err){
            callback(err,null);
          }else{
            callback(null,data);
          }
        });
      }
    ],function(err,data){
      if(err){
        if(err=="other"){
          res.status(200).json({status:SUCCESS});
        }else{
          res.status(400).json({status:FAIL,result:err});
        }
      }else{
        res.status(200).json({status:SUCCESS});
      }
    });
  };

  this.profile = function(req,res){
    var tok = req.headers.authorization;
    var token = tok.substring(7,tok.length);
    async.waterfall([
      function(callback){
        db.que('SELECT * FROM akun WHERE token = ?',token,function(err,data){
          if(err){
            callback(err,null);
          }else{
            callback(null,data[0]);
          }
        });
      },
      function(dataUser,callback){
        db.que('SELECT * FROM device WHERE email = ?',dataUser.email,function(err,data){
          if(err){
            if(err=="other"){
              callback(null,dataUser,null);
            }else{
              callback(err,null,null);
            }
          }else{
            callback(null,dataUser,data);
          }
        });
      },
      function(dataUser,dataDevice,callback){
        db.que('SELECT * FROM jemur WHERE email = ?',dataUser.email,function(err,data){
          if(err){
            if(err=="other"){
              callback(null,dataUser,dataDevice,null);
            }else{
              callback(err,null,null,null);
            }
          }else{
            callback(null,dataUser,dataDevice,data);
          }
        });
      }
    ],function(err,resultUser,resultDevice,resultRiwayat){
      if(err){
        res.status(400).json({status:FAIL,result:err});
      }else{
        res.status(200).json({status:SUCCESS,result:{profile:resultUser,devices:resultDevice,riwayat:resultRiwayat}});
      }
    });
  };
}

module.exports = new API();
