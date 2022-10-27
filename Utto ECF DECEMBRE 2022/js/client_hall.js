
/* Afficher tous les clients_halls */
function JsClientHallSearch(psInstallId, psClientId, pnNoPage) {     
  var sInnerHTML = fGetFile("z_client_halls.php?client_id=" + psClientId + "&install_id=" + psInstallId + "&nopage=" + pnNoPage);  
  document.getElementById("contenu").innerHTML = sInnerHTML;
}

/* Méthodes de recherche*/
function JsClientHallSearchHallName(psInstallId, psClientId, psHallName, pnNoPage) {
  /* alert('JsClientHallSearchHallName'); */
  console.log(psClientId + "," + psInstallId);

  document.getElementById("noFiltre").value = "1";
  document.getElementById("branch_id").value = "";
  var sInnerHTML = fGetFile("z_client_halls.php?client_id=" + psClientId + "&install_id=" + psInstallId + "&hall_name=" + psHallName + "&nopage=" + pnNoPage);
  document.getElementById("contenu").innerHTML = sInnerHTML;
}
function JsClientHallSearchBranchId(psInstallId, psClientId, psBranchId, pnNoPage) {
  document.getElementById("noFiltre").value = "2";
  document.getElementById("hall_name").value = "";
  console.log(psClientId + "," + psInstallId);
  var sInnerHTML = fGetFile("z_client_halls.php?client_id=" + psClientId + "&install_id=" + psInstallId + "&branch_id=" + psBranchId + "&nopage=" + pnNoPage);
  document.getElementById("contenu").innerHTML = sInnerHTML;
}

function JsClientHallSearchHallActive(psInstallId, psClientId, pnHallActive, pnNoPage) {
  console.log(pnHallActive + "," + psInstallId);
  if (pnHallActive == 0) {
    document.getElementById("noFiltre").value = "3";
  }
  else if (pnHallActive == 1) {
    document.getElementById("noFiltre").value = "4";
  }
  else {
    document.getElementById("noFiltre").value = "5";
  }
 
 
  document.getElementById("hall_name").value = "";
  document.getElementById("branch_id").value = "";
  var sInnerHTML = fGetFile("z_client_halls.php?client_id=" + psClientId + "&install_id=" + psInstallId + "&hall_active=" + pnHallActive + "&nopage=" + pnNoPage);
  document.getElementById("contenu").innerHTML = sInnerHTML;
}

/* Méthode appellée en cliquant sur un N0 de page*/
function JsClientHallChangerPage(psInstallId,psClientId, pnNoPage) {
  var sNoFiltre = document.getElementById("noFiltre").value;
  var sHallName = document.getElementById("hall_name").value;
  var sBranchId = document.getElementById("branch_id").value;

  switch (sNoFiltre) {
    case "1": JsClientHallSearchHallName(psInstallId, psClientId,sHallName, pnNoPage);
      break;
    case "2": JsClientHallSearchBranchId(psInstallId, psClientId, sBranchId, pnNoPage);
      break;
    case "3": JsClientHallSearchHallActive(psInstallId, psClientId, 0, pnNoPage);
      break;
    case "4": JsClientHallSearchHallActive(psInstallId, psClientId, 1, pnNoPage);
      break;
    case "0": JsClientHallSearch(psInstallId, psClientId, pnNoPage);
      break;
  }
}

function JsClientHallActiverDesactiver(psInstallId, psClientId, psBranchId, psNomHall, pObjCheck) {
  //alert(psNomHall);     
  var sMessage = "l'activation";
  if (!pObjCheck.checked)
    sMessage = 'la désactivation';

  sMessage = "Confirmer " + sMessage + " " + psNomHall + " ?"
  var bResult = confirm(sMessage);

  if (bResult) {
    var sRetour = fGetFile("BddExecution.php?action=2&install_id=" + psInstallId + "&client_id=" + psClientId + "&branch_id=" + psBranchId);
    document.getElementById("div_erreur").innerHTML = sRetour;
  }
  else {
    pObjCheck.checked = !pObjCheck.checked;
  }
}
function JsClientHallPermActiverDesactiver(psInstallId, psClientId, psBranchId, psPermName, psPermlib, pObjCheck) {    
  var sMessage = "l'activation de l'option :";
  if (!pObjCheck.checked)
    sMessage = "la désactivation de l'option : ";

  sMessage = "Confirmer " + sMessage + " " + psPermlib + " ?"
  var bResult = confirm(sMessage);

  if (bResult) {
    var sRetour = fGetFile("BddExecution.php?action=3&install_id=" + psInstallId + "&client_id=" + psClientId
      + "&branch_id=" + psBranchId + "&perm_name=" + psPermName + "&perm_lib=" + psPermlib);
    document.getElementById("div_erreur").innerHTML = sRetour;
  }
  else {
    pObjCheck.checked = !pObjCheck.checked;
  }
}
// Ouvrir le formulaire de saisie d'un client_hall
function jsClientHallOpen(psInstallId, psClientId,psBranchId) {
  var sInnerHTML = fGetFile("client_hall.php?client_id=" + psClientId + "&install_id=" + psInstallId + "&branch_id=" + psBranchId);
  document.getElementById("div_principal").innerHTML = sInnerHTML;
}
     