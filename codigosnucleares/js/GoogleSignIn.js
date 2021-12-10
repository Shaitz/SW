/* oauth */
/*384084108129-rblosilev8dr7mekip69paaednbdt3o2.apps.googleusercontent.com*/ 
/*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*/


/**
 * The Sign-In client object.
 */
 var auth2;

 /**
  * Initializes the Sign-In client.
  */
 var initClient = function() {
     gapi.load('auth2', function(){
         /**
          * Retrieve the singleton for the GoogleAuth library and set up the
          * client.
          */
         auth2 = gapi.auth2.init({
             client_id: 'CLIENT_ID.apps.googleusercontent.com'
         });
 
         // Attach the click handler to the sign-in button
         auth2.attachClickHandler('signin-button', {}, onSuccess, onFailure);
     });
 };
 
 /**
  * Handle successful sign-ins.
  */
 var onSuccess = function(user) {
     console.log('Signed in as ' + user.getBasicProfile().getName());
  };
 
 /**
  * Handle sign-in failures.
  */
 var onFailure = function(error) {
     console.log(error);
 };

 function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
  }
  function signOut() 
  {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
}