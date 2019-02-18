var modal = document.getElementById('myDialog');

var btn = document.getElementsByClassName("clickable-row");

var span = document.getElementsByClassName("close")[0];

var i;

for(i = 0; i < btn.length; i++){
	btn[i].onclick = function() {
    	modal.style.display = "block";
	}
}

span.onclick = function() {
    modal.style.display = "none";
    $("#table_det tr").remove(); 
    $('#result').html("");
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        $("#table_det tr").remove();
        $('#result').html("");
    }	
}

function details(pida,namea,classa,contacta,itema,qtya,primarya,approve){
	modal.style.display = "block";

	var items = itema.split("%");
	var qtys = qtya.split("%");

	document.getElementById("pid").innerHTML = pida; document.getElementById("name").innerHTML = namea;
	document.getElementById("class").innerHTML = classa; document.getElementById("contact").innerHTML = contacta;

	document.getElementById("pid").style.color = "white"; document.getElementById("name").style.color = "white";
	document.getElementById("class").style.color = "white"; document.getElementById("contact").style.color = "white";

	var table = document.getElementById("table_det");

	var row = table.insertRow();
	var headerCell = document.createElement("TH");
	headerCell.innerHTML = "Sr No";
	row.appendChild(headerCell); headerCell.style.border = "0";
	var headerCell = document.createElement("TH");
	headerCell.innerHTML = "Items"; headerCell.style.border = "0";
	row.appendChild(headerCell);
	var headerCell = document.createElement("TH");
	headerCell.innerHTML = "Quantity"; headerCell.style.border = "0";
	row.appendChild(headerCell);

	for(i = 1; i < items.length; i++){
		var row = table.insertRow();
		var cell0 = row.insertCell(0); var cell1 = row.insertCell(1); var cell2 = row.insertCell(2);
		$(cell0).html(i); $(cell1).html(items[i]); $(cell2).html(qtys[i]);
		cell0.style.border="0"; cell1.style.border="0"; cell2.style.border="0";
	}

	document.getElementById("approve").onclick = function(){
		if(approve == 0){ var flag = document.getElementById("flag").value; }
		else{ var flag = "none"; }
		$.post("../php/Approve.php", { primary: primarya, approve: approve, flag: flag },
    	function(data) {
	 	$('#result').html(data);
    	});	
	}
}

