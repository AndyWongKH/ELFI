// <iframe id="inscriptionPopUp" src= "inscription.html">
// </iframe>
function AfficherPopUP(){
    console.log("yo")
    let popUp_place = document.getElementById('popUp_place');
    let inscription = document.createElement('iframe');
    inscription.classList.add('inscriptionPopUp');
    inscription.setAttribute('src','connexion.html');
    inscription.setAttribute('id','iframe_connexion');
    popUp_place.appendChild(inscription);
}

function FermerPopUp(){
    let connexion_frame = window.parent.document.getElementById('iframe_connexion');
    connexion_frame.parentNode.removeChild(window.parent.document.getElementById('iframe_connexion'));
}
