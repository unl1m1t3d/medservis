
	/************************************************************************************************************
	Editable select
	Copyright (C) September 2005  DHTMLGoodies.com, Alf Magne Kalleland
	
	This library is free software; you can redistribute it and/or
	modify it under the terms of the GNU Lesser General Public
	License as published by the Free Software Foundation; either
	version 2.1 of the License, or (at your option) any later version.
	
	This library is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
	Lesser General Public License for more details.
	
	You should have received a copy of the GNU Lesser General Public
	License along with this library; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
	
	Dhtmlgoodies.com., hereby disclaims all copyright interest in this script
	written by Alf Magne Kalleland.
	
	Alf Magne Kalleland, 2006
	Owner of DHTMLgoodies.com
		
	************************************************************************************************************/	

	
	// Path to arrow images
	var arrowImage = 'images/select_arrow.gif';	// Regular arrow
	var arrowImageOver = 'images/select_arrow_over.gif';	// Mouse over
	var arrowImageDown = 'images/select_arrow_down.gif';	// Mouse down

	
	var selectBoxIds = 0;
	var currentlyOpenedOptionBox = false;
	var editableSelect_activeArrow = false;

	
	function selectBox_switchImageUrl()
	{
		if(this.src.indexOf(arrowImage)>=0){
			this.src = this.src.replace(arrowImage,arrowImageOver);	
		}else{
			this.src = this.src.replace(arrowImageOver,arrowImage);
		}
		
		
	}
	
	function selectBox_showOptions()
	{
		if(editableSelect_activeArrow && editableSelect_activeArrow!=this){
			editableSelect_activeArrow.src = arrowImage;
			
		}
		editableSelect_activeArrow = this;
		
		var numId = this.id.replace(/[^\d]/g,'');
		var optionDiv = document.getElementById('selectBoxOptions' + numId);
		if(optionDiv.style.display=='block'){
			optionDiv.style.display='none';
			this.parentNode.setAttribute("wasClicked","false");
			if(navigator.userAgent.indexOf('MSIE')>=0)document.getElementById('selectBoxIframe' + numId).style.display='none';
			this.src = arrowImageOver;	
		}else{			
			optionDiv.style.display='block';
			this.parentNode.setAttribute("wasClicked","true");
			if(navigator.userAgent.indexOf('MSIE')>=0)document.getElementById('selectBoxIframe' + numId).style.display='block';
			this.src = arrowImageDown;	
			if(currentlyOpenedOptionBox && currentlyOpenedOptionBox!=optionDiv)currentlyOpenedOptionBox.style.display='none';	
			currentlyOpenedOptionBox= optionDiv;			
		}
	}
	
	function selectOptionValue()
	{
		var parentNode = this.parentNode.parentNode;
		var textInput = parentNode.getElementsByTagName('INPUT')[0];
		textInput.value = this.innerHTML.replace(new RegExp("</?strong>","ig"),"");
		this.parentNode.style.display='none';	
		document.getElementById('arrowSelectBox' + parentNode.id.replace(/[^\d]/g,'')).src = arrowImageOver;
		
		if(navigator.userAgent.indexOf('MSIE')>=0)document.getElementById('selectBoxIframe' + parentNode.id.replace(/[^\d]/g,'')).style.display='none';
		
	}
	var activeOption;
	function highlightSelectBoxOption()
	{
		if(this.style.backgroundColor=='#316AC5'){
			this.style.backgroundColor='';
			this.style.color='';
		}else{
			this.style.backgroundColor='#316AC5';
			this.style.color='#FFF';			
		}	
		
		if(activeOption){
			activeOption.style.backgroundColor='';
			activeOption.style.color='';			
		}
		activeOption = this;
		
	}
	function preg_quote(str) 
	{    // Quote regular expression characters
		return str.replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
	}
	function searchInOptions()
	{
			var options=this.getAttribute('selectBoxOptions').split(";");
			var exp=this.value;
			var optionDiv=this.parentElement.lastChild;
			optionDiv.innerHTML="";
			var i,c=0;
			var optionsTotalHeight = 0;
			var optionArray = new Array();
			for(i=0;i<options.length;i++)
			{
				if(options[i].toLowerCase().match(new RegExp(preg_quote(exp.toLowerCase(),"g")))!=null)
				{
					var anOption = document.createElement('DIV');
					anOption.innerHTML = options[i].replace(new RegExp(preg_quote(exp,"ig")),"<strong>$&</strong>");
					anOption.className='selectBoxAnOption';
					anOption.onclick = selectOptionValue;
					anOption.style.width = optionDiv.style.width.replace('px','') - 2 + 'px'; 
					anOption.onmouseover = highlightSelectBoxOption;
					optionDiv.appendChild(anOption);
					optionsTotalHeight = optionsTotalHeight + anOption.offsetHeight;
					optionArray.push(anOption);
					c++;
				}
			}
			if(optionsTotalHeight > optionDiv.offsetHeight)
			{				
				for(var no=0;no<optionArray.length;no++)
				{
					optionArray[no].style.width = optionDiv.style.width.replace('px','') - 22 + 'px'; 	
				}
			}
			
			if((exp=="")&&(this.parentNode.getAttribute("wasClicked")=='false'))
			{
				this.parentNode.childNodes[1].src=arrowImage;
				optionDiv.style.display='none';
			}
			else 
			optionDiv.style.display='block';
		return c;
	}
	function reloadOptions(id,options)
	{
		$('#'+id+' > :last > *').remove();
		$('#'+id).attr('selectBoxOptions',options);
		options = options.split(';');
		var optionDiv=document.getElementById(id).lastChild;
			var optionsTotalHeight = 0;
			var optionArray = new Array();
			for(var no=0;no<options.length;no++){
				var anOption = document.createElement('DIV');
				anOption.innerHTML = options[no];
				anOption.className='selectBoxAnOption';
				anOption.onclick = selectOptionValue;
				anOption.style.width = optionDiv.style.width.replace('px','') - 2 + 'px'; 
				anOption.onmouseover = highlightSelectBoxOption;
				optionDiv.appendChild(anOption);	
				optionsTotalHeight = optionsTotalHeight + anOption.offsetHeight;
				optionArray.push(anOption);
			}
			if(optionsTotalHeight > optionDiv.offsetHeight){				
				for(var no=0;no<optionArray.length;no++){
					optionArray[no].style.width = optionDiv.style.width.replace('px','') - 22 + 'px'; 	
				}	
			}		
			optionDiv.style.display='none';
			optionDiv.style.visibility='visible';
	}
	function addNewOption()
	{
		if(searchInOptions()==0)
		{
			
			var optionsTotalHeight = 0;
			var optionArray = new Array();
			var optionDiv=this.parentElement.lastChild;
			var anOption = document.createElement('DIV');
					anOption.innerHTML = this.value;
					anOption.className='selectBoxAnOption';
					anOption.onclick = selectOptionValue;
					anOption.style.width = optionDiv.style.width.replace('px','') - 2 + 'px'; 
					anOption.onmouseover = highlightSelectBoxOption;
					optionDiv.appendChild(anOption);
					optionsTotalHeight = optionsTotalHeight + anOption.offsetHeight;
					optionArray.push(anOption);
			s=this.getAttribute('newOptions');
			this.setAttribute('newOptions',s+this.value+";");
			if(optionsTotalHeight > optionDiv.offsetHeight)
			{				
				for(var no=0;no<optionArray.length;no++)
				{
					optionArray[no].style.width = optionDiv.style.width.replace('px','') - 22 + 'px'; 	
				}
			}
		}
	}
	function createEditableSelect(dest)
	{
		dest.className='selectBoxInput';
		dest.oninput=searchInOptions;
		dest.onBlur=addNewOption;
		var div = document.createElement('DIV');
		div.style.styleFloat = 'left';
		div.style.width = dest.offsetWidth + 16 + 'px';
		div.style.position = 'relative';
		div.id = 'selectBox' + selectBoxIds;
		var parent = dest.parentNode;
		parent.insertBefore(div,dest);
		div.appendChild(dest);	
		div.className='selectBox';
		div.style.zIndex = 10000 - selectBoxIds;
		div.setAttribute("wasClicked","false");
		
		
		var img = document.createElement('IMG');
		img.src = arrowImage;
		img.className = 'selectBoxArrow';
		img.onmouseover = selectBox_switchImageUrl;
		img.onmouseout = selectBox_switchImageUrl;
		img.onclick = selectBox_showOptions;
		img.id = 'arrowSelectBox' + selectBoxIds;

		div.appendChild(img);
		var source=dest.getAttribute('source');
		if(source=="sbase_get_dolzhnost_list.php")
		{
			if(s_dolzhnost.length<=0)
			{
				request.open("GET","sbase_get_dolzhnost_list.php",false);
				request.send();
				if(request.readyState==4)
					if(request.status==200)
					{
						s_dolzhnost=request.responseText.split(';');
						dest.setAttribute('selectBoxOptions',request.responseText);
					}
			}
			else
			{
				var array_copy = [].concat(s_dolzhnost);
				dest.setAttribute('selectBoxOptions',array_copy.join(";"));
			}
		}
		else if(source=="sbase_get_ways_of_paying.php")
		{
			if(s_ways_of_paying.length<=0)
			{
				request.open("GET","sbase_get_ways_of_paying.php",false);
				request.send();
				if(request.readyState==4)
					if(request.status==200)
					{
						s_ways_of_paying=request.responseText.split(';');
						dest.setAttribute('selectBoxOptions',request.responseText);
					}
			}
			else
			{
				var array_copy = [].concat(s_ways_of_paying);
				dest.setAttribute('selectBoxOptions',array_copy.join(";"));
			}
		}
		else if(source=="sbase_get_stations_list.php")
		{
			if(s_stations.length<=0)
			{
				request.open("GET","sbase_get_stations_list.php",false);
				request.send();
				if(request.readyState==4)
					if(request.status==200)
					{
						s_stations=request.responseText.split(';');
						dest.setAttribute('selectBoxOptions',request.responseText);
					}
			}
			else
			{
				var array_copy = [].concat(s_stations);
				dest.setAttribute('selectBoxOptions',array_copy.join(";"));
			}
		}
		else if(source=="sbase_get_services_list.php")
		{
				request.open("GET","sbase_get_services_list.php",false);
				request.send();
				if(request.readyState==4)
					if(request.status==200)
					{
						s_stations=request.responseText.split(';');
						dest.setAttribute('selectBoxOptions',request.responseText);
					}
		}
		else if(source=="sbase_get_clinics_list.php")
		{
			if(s_clinics.length<=0)
			{
				request.open("GET","sbase_get_clinics_list.php",false);
				request.send();
				if(request.readyState==4)
					if(request.status==200)
					{
						s_clinics=request.responseText.split(';');
						dest.setAttribute('selectBoxOptions',request.responseText);
					}
			}
			else
			{
				var array_copy = [].concat(s_clinics);
				dest.setAttribute('selectBoxOptions',array_copy.join(";"));
			}
		}
		var optionDiv = document.createElement('DIV');
		optionDiv.id = 'selectBoxOptions' + selectBoxIds;
		optionDiv.className='selectBoxOptionContainer';
		optionDiv.style.width = div.offsetWidth-2 + 'px';
		div.appendChild(optionDiv);
		
		if(navigator.userAgent.indexOf('MSIE')>=0){
			var iframe = document.createElement('<IFRAME src="about:blank" frameborder=0>');
			iframe.style.width = optionDiv.style.width;
			iframe.style.height = optionDiv.offsetHeight + 'px';
			iframe.style.display='none';
			iframe.id = 'selectBoxIframe' + selectBoxIds;
			div.appendChild(iframe);
		}
		
		if(dest.getAttribute('selectBoxOptions')){
			
			var options = dest.getAttribute('selectBoxOptions').split(';');
			var optionsTotalHeight = 0;
			var optionArray = new Array();
			for(var no=0;no<options.length;no++){
				var anOption = document.createElement('DIV');
				anOption.innerHTML = options[no];
				anOption.className='selectBoxAnOption';
				anOption.onclick = selectOptionValue;
				anOption.style.width = optionDiv.style.width.replace('px','') - 2 + 'px'; 
				anOption.onmouseover = highlightSelectBoxOption;
				optionDiv.appendChild(anOption);	
				optionsTotalHeight = optionsTotalHeight + anOption.offsetHeight;
				optionArray.push(anOption);
			}
			if(optionsTotalHeight > optionDiv.offsetHeight){				
				for(var no=0;no<optionArray.length;no++){
					optionArray[no].style.width = optionDiv.style.width.replace('px','') - 22 + 'px'; 	
				}	
			}		
			optionDiv.style.display='none';
			optionDiv.style.visibility='visible';
		}
		
		selectBoxIds = selectBoxIds + 1;
	}	

