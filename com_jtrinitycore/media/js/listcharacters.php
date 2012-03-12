<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
header('Content-Type: text/javascript'); 

?> 
<script type="text/javascript">
var getXhr = (function () {
    if ("XMLHttpRequest" in window) {
        return function () {
            return new XMLHttpRequest();
        };
    }
    else {
        var item = (function () {
            var list = ["Microsoft", "Msxml2", "Msxml3"],
                i = list.length;
            while (i--) {
                try {
                    item = list[i] + ".XMLHTTP";
                    var obj = new ActiveXObject(item);
                    return item;
                }
                catch (e) {}
            }
        }());
        return function () {
            return new ActiveXObject(item);
        };
    } // else
}());

function ajxGetCharacters(realm_id, showgold) {

	
    var xhr = getXhr();
  
    xhr.onreadystatechange = function() {
    	
      if(xhr.readyState == 4 && xhr.status == 200) {
          var character=document.getElementById('characterid');
          try //Internet Explorer
          {
            xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
            xmlDoc.async="false";
            xmlDoc.loadXML(xhr.responseText);
          }
        catch(e)
          {
          try //Firefox, Mozilla, Opera, etc.
            {
              parser=new DOMParser();
              xmlDoc=parser.parseFromString(xhr.responseText,"text/xml");
            }
          catch(e) {alert(e.message)}
          }
          var options =xmlDoc.getElementsByTagName('options').item(0);
          character.innerHTML=''; 
             
			
          for (i=0; i < options.childNodes.length; i++) {         	         
            var newoption=document.createElement("option");
            var myoption=options.childNodes[i];
            var newtext=document.createTextNode(myoption.childNodes[0].nodeValue);
            newoption.setAttribute("value",myoption.getAttributeNode('id').value)
            newoption.appendChild(newtext);
            character.appendChild(newoption);
           
          } 
      } // if
    } // function
 
   	  if (!showgold) showgold=0;
   	
      xhr.open("GET","index.php?option=com_jtrinitycore&format=raw&task=listcharacters&realm_id="+realm_id+"&showgold="+showgold,true);
      xhr.send(null);
} // ajxGetCharacters

function validateForm()
{
	//var c=document.forms["frmBuy"]["character"].value;
	if (document.getElementById("characterid").value==0)
	  {
	  	alert("<?php  echo JText::_('COM_JTRINITYCORE_ALERT_SELECTCHARACTER');?>");
	  	return false;
	  }

	  return true;
}
</script>