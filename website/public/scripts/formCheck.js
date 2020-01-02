const RE_NUMERIC = /^[1-9][0-9]{0,3}$/;
const RE_YOUTUBE =  /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})?$/;
var errorMessage = ""; //gestita da createErrorMessage

/* 
    controlla se l'item non è vuoto ==> ritorna booleano
*/
function isValidInput(item,type=null){
    if (item.value==""){
        createEmptyErrorMessage(item,type);
        return false;
    }
    else{
        return true;
    }  
}

/* 
    controlla se l'item rispetta l'espressione regolare per i numeri ==> ritorna booleano
*/
function isValidNumericInput(item,type){
    if (!RE_NUMERIC.test(item.value)){
        createNaNErrorMessage(item,type);
        return false;
    } 
    else
        return true;
}

function isValidUrl(item){
    if(isValidInput(item) && !RE_YOUTUBE.test(item.value)){
        alert("L'URL del video non è in un formato valido.")
        return false;
    }
    return true;
}

/*
    ritorna il PRIMO item che soddisfa la condizione (che non è valido)
    se nessuno la soddisfa, ritorna undefined (nel caso sia tutto ok)
*/
function findInvalidItem(listItems,type,isValidFunction){
    return listItems.find(element => { 
        return !isValidFunction(element,type); 
    })           
}

/* 
    crea messaggio errore personalizzato e focalizza la casella incriminata
*/
function errorMessageGenerator(item){
    alert(errorMessage);
    item.focus();  
}

function isEmptyInput(listElements,type){
    var invalidItem = findInvalidItem(listElements,type,isValidInput);
    if (invalidItem!=undefined){
        errorMessageGenerator(invalidItem);  
        return true;
    }
    return false;
}


function isNumericInput(listElements,type){
    var invalidItem = findInvalidItem(listElements,type,isValidNumericInput);
    if (invalidItem!=undefined){
        errorMessageGenerator(invalidItem);  
        return false;
    }
    return true;
}


function isValidFormFeed() {
    var subtitle = document.getElementById("subtitle");
    var content = document.getElementById("content");
    var videoUrl = document.getElementById("videoUrl");
    return !isEmptyInput([subtitle,content],"feed") 
            && isValidUrl(videoUrl);
}

function isValidFormEpisode(){
    var titleEpisode = document.getElementById("titleEpisode");
    var description = document.getElementById("description");
    var promoUrl = document.getElementById("promoUrl");
    return !isEmptyInput([titleEpisode,description],"episode") 
            && isValidUrl(promoUrl);
}

function isValidFormMedia(){
    var mediaTitle = document.getElementById("mediaTitle");
    var description = document.getElementById("description");
    var duration = document.getElementById("duration");
    var stars = document.getElementById("stars");
    var numSeasons = document.getElementById("numSeasons");
    var numEpisodes = document.getElementById("numEpisodes");
    var trailerUrl = document.getElementById("trailerUrl");
    if (document.getElementById("radioTvSeries").checked){
        return !isEmptyInput([mediaTitle,description,duration,stars,numSeasons,numEpisodes],"media") 
                && isNumericInput([duration,numSeasons,numEpisodes],"media")
                && isValidUrl(trailerUrl); 
    }
    else{
        return !isEmptyInput([mediaTitle,description,duration,stars],"media") 
                && isNumericInput([duration],"media")
                && isValidUrl(trailerUrl); 
    }
}

/*
crea messaggio di errore personalizzato in base all'item passato
type è una stringa, specifica se si deve creare un errore per la form di inserimento "media", "feed" o "episodio"
*/
function createEmptyErrorMessage(item, type){
    if (type=="feed"){
        switch (item.name) {
            case 'subtitle': errorMessage = "Inserisci il sottotitolo.";
                break;
            case 'content': errorMessage = "Inserisci il contenuto.";
                break;
            default: errorMessage = "Campo vuoto";
        }
    }
    else if (type == "episode"){
        switch (item.name) {
            case 'titleEpisode': errorMessage = "Inserisci il titolo.";
                break;
            case 'description': errorMessage = "Inserisci la descrizione.";
                break;
            default: errorMessage = "Campo vuoto";
        }
    }
    else if(type == "media"){
        switch (item.name) {
            case 'mediaTitle': errorMessage = "Inserisci il titolo.";
                break;
            case 'description': errorMessage = "Inserisci la descrizione.";
                break;
            case 'duration': errorMessage = "Inserisci la durata.";
                break;
            case 'stars': errorMessage = "Inserisci la valutazione.";
                break;
            case 'numSeasons': errorMessage = "Inserisci il numero di stagioni.";
                break;
            case 'numEpisodes': errorMessage = "Inserisci il numero di episodi per stagione.";
                break;
            default: errorMessage = "Campo vuoto";
        }
    }
}

function createNaNErrorMessage(item,type){
    if (type == "media"){
        switch (item.name) {
            case 'duration': errorMessage = "La durata deve essere un valore numerico diverso da 0.";
                break;
            case 'numSeasons': errorMessage = "Numero stagioni deve essere un valore numerico diverso da 0.";
                break;
            case 'numEpisodes': errorMessage = "Episodi stagione deve essere un valore numerico diverso da 0.";
                break;
            default: errorMessage = "Durata, numero stagioni e episodi per stagione devono contenere valori numerici diversi da 0.";
        }
    }

}

function showEpisodesInput($toShow){
    // This will disable all the children of the div
    var seasonsNum = document.getElementById("seasonsNum");
    var episodesNum = document.getElementById("episodesNum");
    var numSeasons = document.getElementById("numSeasons");
    var numEpisodes = document.getElementById("numEpisodes");
    if (!$toShow){
        seasonsNum.className = "group-insert hidden";
        numSeasons.tabIndex = -1;
        episodesNum.className = "group-insert hidden";
        numEpisodes.tabIndex = -1;
    }
    else{
        seasonsNum.className = "group-insert";
        numSeasons.tabIndex = 0;
        episodesNum.className = "group-insert";
        numEpisodes.tabIndex = 0;
    }
}
