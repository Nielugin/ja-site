
function nomSaisi (e) {
	var valNom = e.value;
	//recuperer le div de groupe
	var divGroup = e.parentNode.parentNode;
	var classDivGroup = "has-feedback ";
	//recuperer le span s'il existe
	var spanGly = e.parentNode.getElementsByTagName('span');
	if (spanGly.length == 0) {
		spanGly = document.createElement('span');
		e.parentNode.appendChild(spanGly);
	} else {
		spanGly = spanGly[0];
	}
	spanGly.className = "glyphicon form-control-feedback "
	
	if (valNom == "") {
		classDivGroup = " has-error "+classDivGroup;
		divGroup.className = classDivGroup;
		spanGly.className += "glyphicon-remove";
		// Add tooltip pour expliquer pourquoi c'est pas bon
	} else {
		classDivGroup = " has-success "+classDivGroup;
		divGroup.className = classDivGroup;
		spanGly.className += "glyphicon-ok";
	}
	
}



// Fonction qui permet d'afficher le block de l'adresse de la mère 
function change_checkbox(el){
	var divAdresseMere = document.getElementById('adresseMere');
	var divAdressePere = document.getElementById("adressePere");
	var labelAdresse = divAdressePere.getElementsByTagName("label")[0];
		
	if(el.checked){  
		divAdresseMere.style.display = 'block';
		labelAdresse.innerHTML = 'Adresse (Père):'
	}else{
		divAdresseMere.style.display = 'none';
		labelAdresse.innerHTML = 'Adresse:'
	}
}


// Fonction qui affiche le block des coordonnées des responsables si l'adhérent est mineur
function display_DivMineur(e) {
	var dateNaissance = new Date(document.getElementById('dateNaissance').value);
	var dateAuj = new Date();
	var age = (dateAuj - dateNaissance)/(3600000*24*365);
	if (age < 18) {
		document.getElementById("mineur").style.display = 'block';
		document.getElementById("interventionMineur").innerHTML = "mon enfant";
	} else {
		document.getElementById("mineur").style.display = 'none';
		document.getElementById("interventionMineur").innerHTML = "moi";
	}
}

//Fonction qui copie les champs de l'enfant à celui des parents
function copy_AddressInput(e) {
	var idInput = e.id;
	document.getElementById(idInput+"Pere").value = e.value;
	document.getElementById(idInput+"Mere").value = e.value;
}