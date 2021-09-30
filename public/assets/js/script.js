/**
 * Imprimer un document
 */
function imprimer(divName)
{
    var printContents = document.getElementById(divName).innerHTML;
    var originContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}


/**
 * Calculer le total du jours d'absence
 */
function total()
{
	var dureeMaladie = document.getElementsByClassName("dureeMaladie");
	var total_dureeMaladie=0;
	for (var i = 0; i < dureeMaladie.length; i++) {
	  total_dureeMaladie += parseInt(dureeMaladie[i].innerHTML);
	}
	var dureeExcep = document.getElementsByClassName("dureeExcep");
	var total_dureeExcep=0;
	for (var j = 0; j < dureeExcep.length; j++) {
	  total_dureeExcep += parseInt(dureeExcep[j].innerHTML);
	}
                    
    document.getElementById("totalMaladie").innerHTML="Total (Congés de maladie) : " + total_dureeMaladie + " jours";
    document.getElementById("totalExcep").innerHTML="Total (Autorisations exceptionnelles) : " + total_dureeExcep + " jours";
}