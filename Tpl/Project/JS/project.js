// JavaScript Document
var color=false;
function clickadd(){
		var form=document.getElementById("project");
		var btnadd=document.getElementById("btnadd");
		form.removeChild(btnadd);
		var span=document.createElement("span");
		var input1=document.createElement("input");
		input1.type='text';
		input1.name='item';
		input1.id='item';
		input1.placeholder='物品';
		input1.style.margin='3px';
		var input2=document.createElement("input");
		input2.type='text';
		input2.name='amount';
		input2.id='amount';
		input2.placeholder='数量';
		input2.style.margin='3px';
		var btnok=document.createElement("input");
		btnok.type='button';
		btnok.name='submit';
		btnok.value='添加';
		btnok.setAttribute("onclick","add()");
		btnok.setAttribute("href","javascript:void(0);");
		var lable=document.createElement("lable");
		lable.id="input_add";
		lable.style.display='block';
		lable.style.padding='8px';
		span.appendChild(input1);
		span.appendChild(input2);
		span.appendChild(btnok);
		lable.appendChild(span);
		form.appendChild(lable);
}

function addtable(json,amount){
	alert('添加'+json.id+':'+json.name+''+amount+'个');
}