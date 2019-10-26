/* 
    espressioni regolari per la validazione dei campi 
*/
const RE_PASSWORD = /^(?=.*[0-9])(?=.*[a-z])[a-zA-Z0-9!.@#$%^&*]{6,16}$/;
const RE_EMAIL = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
const RE_NAME = /^[a-zA-Z]{3,16}$/;
const RE_USERNAME = /^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/


/* 
    controlla se l'item rispetta l'espressione regolare ==> ritorna booleano
*/
function validInput(item, reg_expr){
    if (reg_expr.test(item.value))
        return true;
    else
        return false;
}

/*
    validazione form login
*/
function validateFormLogin() {
     
    var username = document.getElementById("username");
    var password = document.getElementById("password");

   
    if (!validInput(username, RE_USERNAME))                                  
    { 
        alert("Username non valido."); 
        username.focus(); 
        return false; 
    } 
   
    if (!validInput(password, RE_PASSWORD))                               
    { 
        alert("Password erratta."); 
        password.focus(); 
        return false; 
    } 
   
    return true; 
}


function validateFormRegistration() {
     
    var username = document.getElementById("username");
    var password = document.getElementById("password");

   
    if (!validInput(username, RE_USERNAME))                                  
    { 
        alert("Username non valido."); 
        username.focus(); 
        return false; 
    } 
   
    if (!validInput(password, RE_PASSWORD))                               
    { 
        alert("Password errata."); 
        password.focus(); 
        return false; 
    } 
   
    return true; 
}



  