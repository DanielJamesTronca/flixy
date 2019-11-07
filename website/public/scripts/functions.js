
// variables to use menu using keyboard
const SPACEBAR_KEY_CODE = [0,32];
const ENTER_KEY_CODE = 13;
const DOWN_ARROW_KEY_CODE = 40;
const UP_ARROW_KEY_CODE = 38;
const ESCAPE_KEY_CODE = 27;

var rotatedButton1 = false;
var rotatedButton2 = false;
function rotateBttn(id) {
    button = document.getElementById(id);
    if (id === "button1") {
        var deg = rotatedButton1 ? 180 : 0;
        button.style.webkitTransform = 'rotate('+deg+'deg)'; 
        button.style.mozTransform = 'rotate('+deg+'deg)'; 
        button.style.msTransform = 'rotate('+deg+'deg)'; 
        button.style.oTransform = 'rotate('+deg+'deg)'; 
        button.style.transform = 'rotate('+deg+'deg)'; 

    } else {
        deg = rotatedButton2 ? 180 : 0;
        button.style.webkitTransform = 'rotate('+deg+'deg)'; 
        button.style.mozTransform = 'rotate('+deg+'deg)'; 
        button.style.msTransform = 'rotate('+deg+'deg)'; 
        button.style.oTransform = 'rotate('+deg+'deg)'; 
        button.style.transform = 'rotate('+deg+'deg)'; 
    }
    
}

function showYearDropDown() {
    let dropYear = document.getElementById('drop1');
    dropYear.classList.toggle("hidden");
    rotatedButton1 = !rotatedButton1;
    rotateBttn("button1");
}

function showGenreDropDown() {
    let dropYear = document.getElementById('drop2');
    dropYear.classList.toggle("hidden");
    rotatedButton2 = !rotatedButton2;
    rotateBttn("button2");
}

const arrayYear = [
    "option1",
    "option2",
    "option3",
    "option4",
    "option5"
]

const arrayGenre = [
    "genre1",
    "genre2",
    "genre3",
    "genre4",
    "genre5"
]

window.onload = function createDropdownYear() {
    for (let i=0; i < arrayYear.length; i++) {
        let liTag = document.createElement("LI");
        let aTag = document.createElement("A");
        document.getElementById("drop1").appendChild(liTag);
        aTag.innerHTML = arrayYear[i];
        liTag.appendChild(aTag);
        liTag.setAttribute("aria-labelledby", "year-label");
        liTag.setAttribute("tabindex", "0");
    }
    for (let i=0; i < arrayGenre.length; i++) {
        let liTag = document.createElement("LI");
        let aTag = document.createElement("A");
        document.getElementById("drop2").appendChild(liTag);
        aTag.innerHTML = arrayGenre[i];
        liTag.appendChild(aTag);
        liTag.setAttribute("aria-labelledby", "genre-label");
        liTag.setAttribute("tabindex", "0");
    }
}
