function init_tabs()
{
	var m = document.getElementById('tabs');
	var s = document.createElement('table');  //div
	s.setAttribute("class", "table table-hover")
	var tbody = document.createElement('tbody');
	tbody.setAttribute("id","grid_7");
	s.appendChild(tbody);
	m.appendChild(s);
	m = document.getElementById('grid_7');
	for(var i=0;i<subs.length;i++)
	{
		if(subs[i].cfid === "") continue;
			
		var tr = document.createElement('tr');
		var td = document.createElement('td');
		tr.setAttribute("id","sub"+i);

		if(subs[i].submitted=='0')
		{
			td.setAttribute("class","feedback-module");
			td.setAttribute("onclick","javascript:questions("+i+");");
			//p.style.backgroundColor="rgb(190, 40, 40)";   //feedback not giver make it red
		}
		else
		{
			td.setAttribute("class","feedback-given");
			td.setAttribute('class',"success")
			//p.style.backgroundColor="rgb(30, 148, 25)";  //feedback give make it green
		}
		var name=document.createElement('span');
		name.setAttribute("id","subject_name");
		name.innerHTML=subs[i].name;
		// var td2 = document.createElement('td');
		td.appendChild(name);
		tr.appendChild(td);
		m.appendChild(tr);
	}
}
function questions(index){
	subs_index = index;
	var tabs=document.getElementById('tabs');
	tabs.style.display="none";
	document.getElementById("navigation").style.display="block";
	if(subs[index].lab == "0") {
		var lab = "theory";
		var idd = "t0";
		var qcount = appData.qtheory;
	}
	else if(subs[index].lab == "1") {
		var lab = "lab";
		var idd = "l0";
		var qcount = appData.qlab;
	}
	var ques=document.getElementById("ques_"+lab);
	ques.style.display="block";
	document.getElementById(lab+"_tr1").innerHTML=subs[index].cid;
	document.getElementById(lab+"_tr2").innerHTML=subs[index].name;
	document.getElementById(lab+"_tr3").innerHTML=subs[index].fname;
	form(idd, qcount);
}
function submmit(){
	var index = subs_index;
	var cur_sub = subs[index];
	if (cur_sub.lab == "0") {
		var qcount = appData.qtheory;
		var lab = "t";
		var url = "theory";
	}
	else {
		var qcount = appData.qlab;
		var lab = "l";
		var url = "lab";
	}
	if (cur_sub.submitted != "0") {
		document.getElementById('tabs').style.display="block";
		document.getElementById("ques_"+lab).style.display="none";
		return;
	}
	cur_sub.submitted = "1";
	document.getElementById(lab+"_submit").style.display="none";	
				
	document.getElementById("sub"+index).setAttribute("onclick",";");		
		
	var feed_input = new Array();

	if(document.getElementById(lab+"0").checked){
		feed_input[0] = "y";
		var filled = true;
		for(var k=1;k < qcount;k++){
			var ele = document.getElementById(lab+k);
			if(ele.value == ""){
				filled = false;
				ele.style.border = "#FF0000 2px solid";			
			} else {
				ele.style.border = "";
				feed_input[k] = ele.value;
			}
		}
		if(!filled) {
			alert("Incomplete form. Give response for all questions.");
			cur_sub.submitted = "0";
			if(index == subs_index) {
				document.getElementById(lab+"_submit").style.display="block";
			}
			document.getElementById("sub"+index).setAttribute("onclick","questions("+index+")");
			return;
		}
		feed_input[k] = document.getElementById(lab+"c_postcomment1").value;
		k++;
		feed_input[k] = document.getElementById(lab+"c_postcomment2").value;
		k++;
		feed_input[k] = document.getElementById(lab+"f_postcomment1").value;
		k++;
		feed_input[k] = document.getElementById(lab+"f_postcomment2").value;
	}
	else{
		feed_input[0] = "n";
	}
	
	if(index == subs_index) {
		document.getElementById(lab+"_img").style.display="block";
	}
	document.getElementById("sub"+index).setAttribute("class","feedback-given");
		
	$.post("process_"+url+".php",
			{
				cfid: cur_sub.cfid,
				sub_index: index,
				sub: cur_sub.key,
				'feed_input[]' : feed_input
			})
	.done(function(data) {
				//alert("Data Loaded: " + data);
				switch(data) {
					case "success":
						//alert("Feedback submitted");				
						if(index == subs_index) {
							nextSub ();
						}							
						break;
					case "filled":
						//alert("Feedback already submitted");
						if(index == subs_index) {
							nextSub ();
						}
						break;
					default:
						alert("Error in submitting feedback. Please try again or contact wsdc.nitw@gmail.com");
						if(index == subs_index) {
						//Reapper submit button
						document.getElementById(lab+"_img").style.display="none";	
						document.getElementById(lab+"_submit").style.display="block";								
						}
						cur_sub.submitted = "0";
						document.getElementById("sub"+index).setAttribute("class","feedback-module");
						document.getElementById("sub"+index).setAttribute("onclick","questions("+index+")");					
				}
			})		
	.fail(function(data) {			
				//alert("Data Loaded: " + data);
				alert("Server Down. Please Try Again or contact wsdc.nitw@gmail.com!!.");
				if(index == subs_index) {
					document.getElementById(lab+"_img").style.display="none";	
					document.getElementById(lab+"_submit").style.display="block";
				}
				cur_sub.submitted = "0";
				document.getElementById("sub"+index).setAttribute("class","feedback-module");
				document.getElementById("sub"+index).setAttribute("onclick","questions("+index+")");		
	});
}
function return_home() {
    document.getElementById("ques_theory").style.display = "none";
    document.getElementById("ques_lab").style.display = "none";
    document.getElementById("navigation").style.display="none";
    document.getElementById("tabs").style.display = "block";
}
function form (idd, qcount) {
	empty_form (idd, qcount);
	enable (idd, qcount);
	document.getElementById(idd).checked = true;
}
	
function empty_form (idd,qcount) {
	for(var j=1;j<qcount;j++){
		if(idd == "t0")
			var id = "t";
		else
			var id = "l";
		document.getElementById(id+j).value="";
		document.getElementById(id+j).style.border="";
	}
	if(idd == "t0"){
		var id1 = "tc_postcomment";
		var id2 = "tf_postcomment";
	}
	else{
		var id1 = "lc_postcomment";
		var id2 = "lf_postcomment";
	}
	document.getElementById(id1+"1").value="";			
	document.getElementById(id1+"2").value="";
	document.getElementById(id2+"1").value="";
	document.getElementById(id2+"2").value="";
	document.getElementById(id+"_img").style.display="none";	
	document.getElementById(id+"_submit").style.display="block";
}
	
function enable (idd,qcountt) {
	for(var j=1;j<qcountt;j++){
		if(idd == "t0")
			var id = "t"+j;
		else
			var id = "l"+j;
		document.getElementById(id).disabled=false;
	}
	if(idd == "t0"){
		var id1 = "tc_postcomment";
		var id2 = "tf_postcomment";
	}
	else{
		var id1 = "lc_postcomment";
		var id2 = "lf_postcomment";
	}
	document.getElementById(id1+"1").disabled=false;			
	document.getElementById(id1+"2").disabled=false;
	document.getElementById(id2+"1").disabled=false;
	document.getElementById(id2+"2").disabled=false;
}
function disable (idd,qcountt) {
	for(var j=1;j<qcountt;j++){
		if(idd == "t0")
			var id = "t"+j;
		else
			var id = "l"+j;
		document.getElementById(id).disabled=true;
	}
	if(idd == "t0"){
		var id1 = "tc_postcomment";
		var id2 = "tf_postcomment";
	}
	else{
		var id1 = "lc_postcomment";
		var id2 = "lf_postcomment";
	}
	document.getElementById(id1+"1").disabled=true;			
	document.getElementById(id1+"2").disabled=true;
	document.getElementById(id2+"1").disabled=true;
	document.getElementById(id2+"2").disabled=true;
	empty_form (idd,qcountt);
}
function nextSub () {
	var cur = subs[subs_index];
	var lab;
	switch(cur.lab) {
		case "0":
			lab = "theory";
			break;
		case "1":
			lab = "lab";
			break;
		default:
			return;
	}
	var len = subs.length;
	for (var i = subs_index+1; i < len; ++i) {
		if(subs[i].submitted === "0") {
			document.getElementById("ques_"+lab).style.display = "none";
			questions(i);
            $('html, body').animate({ scrollTop: 0 }, 'fast');
			return;
		}
	}
	for (var i = 0; i < subs_index; ++i) {
		if(subs[i].submitted === "0") {
			document.getElementById("ques_"+lab).style.display = "none";
			questions(i);
            $('html, body').animate({ scrollTop: 0 }, 'fast');
			return;
		}
	}

	document.getElementById("ques_"+lab).style.display = "none";
	document.getElementById("navigation").style.display="none";
	document.getElementById("tabs").style.display="block";
}
function prevSub () {
	var cur = subs[subs_index];
	var lab;
	switch(cur.lab) {
		case "0":
			lab = "theory";
			break;
		case "1":
			lab = "lab";
			break;
		default:
			return;
	}
	var len = subs.length;
	for (var i = subs_index-1; i >= 0; --i) {
		if(subs[i].submitted === "0") {
			document.getElementById("ques_"+lab).style.display = "none";
			questions(i);
            $('html, body').animate({ scrollTop: 0 }, 'fast');
			return;
		}
	}
	for (var i = len-1; i > subs_index; --i) {
		if(subs[i].submitted === "0") {
			document.getElementById("ques_"+lab).style.display = "none";
			questions(i);
            $('html, body').animate({ scrollTop: 0 }, 'fast');
			return;
		}
	}
	document.getElementById("ques_"+lab).style.display = "none";
	document.getElementById("navigation").style.display="none";
	document.getElementById("tabs").style.display="block";
}
