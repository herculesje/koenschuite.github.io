(function() {
    // Initialize Firebase
      var config = {
        apiKey: "AIzaSyDNN4H_iSFStx3cipCDTEP7ClLUqsjijxY",
        authDomain: "coindok-2310.firebaseapp.com",
        databaseURL: "https://coindok-2310.firebaseio.com",
        projectId: "coindok-2310",
        storageBucket: "coindok-2310.appspot.com",
        messagingSenderId: "255968865411"
      };
    
      firebase.initializeApp(config);
    
    //get all the elements 
    
    const emailLogin = document.getElementById('emailLogin');
    const passLogin = document.getElementById('passLogin');
    const btnLogin = document.getElementById('btnLogin');
    const btnRegister = document.getElementById('btnRegister');
    
    
    //add login event
    btnLogin.addEventListener('click', e => {
       const email = emailLogin.value;
       const pass = passLogin.value;
       const auth = firebase.auth();
        
        //Sign in
        auth.signInWithEmailAndPassword(email, pass);
        promise.catch(e => console.log(e.message))
        
    });
    
        //add Register event
    btnRegister.addEventListener('click', e => {
        //TODO Check for real email
       const email = emailLogin.value;
       const pass = passLogin.value;
       const auth = firebase.auth();
        
        //Sign in
        auth.createUserWithEmailAndPassword(email, pass);
        promise.catch(e => console.log(e.message));
        
    });
    
    //add a realtime listener
    firebase.auth().onAuthStateChanged(firebaseUser => {
       if(firebaseUser){
           console.log(firebaseUser);
           $(location).attr('href', 'http://coindok.com/index.php')
       } else{
        console.log('not logged in');
    }
    });
}());  


