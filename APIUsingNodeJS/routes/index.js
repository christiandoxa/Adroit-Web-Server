var express = require('express');
var user = require("../api/user");
var db = require("../database/model");
var passport = require('passport');
var Strategy = require('passport-http-bearer').Strategy;
var router = express.Router();

passport.use(new Strategy(
  function(token, cb) {
    db.findToken(token, function(err, data) {
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
router.put('/profile',passport.authenticate('bearer',{session: false}),user.profileUpdate);
router.put('/update',passport.authenticate('bearer',{session: false}),user.updateDevice);
router.get('/login',passport.authenticate('bearer',{session: false}),user.login);
router.get('/history',passport.authenticate('bearer',{session: false}),user.jemuranGet);
router.put('/history',passport.authenticate('bearer',{session: false}),user.jemuranUpdate);
router.get('/logout',passport.authenticate('bearer',{session: false}),user.logout);
router.post('/history',passport.authenticate('bearer',{session: false}),user.jemuranPost);
router.post('/login',user.loginAwal);
router.post('/SignUp',user.signUp);
router.post('/login/withGmail',user.withGmail);

module.exports = router;
