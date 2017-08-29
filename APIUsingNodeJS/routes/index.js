var express = require('express');
var user = require("../api/user");
var passport = require('passport');
var Strategy = require('passport-http-bearer').Strategy;
var router = express.Router();

passport.use(new Strategy(
  function(token, cb) {
    user.findToken(token, function(err, data) {
      if (err) { return cb(err); }
      if (!data) { return cb(null, false); }
      return cb(null, data);
    });
  }));
/* GET home page. */
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express' });
});
router.get('/device/(:id)?',passport.authenticate('bearer',{session: false}),user.getDevice);
router.get('/profile',passport.authenticate('bearer',{session: false}),user.profile);
router.put('/update',passport.authenticate('bearer',{session: false}),user.updateDevice);
router.get('/login',passport.authenticate('bearer',{session: false}),user.login);
router.post('/login',user.loginAwal);
router.post('/SignUp',user.signUp);
router.post('/login/withGmail',user.withGmail);

module.exports = router;
