var urlBase = 'http://teamcontactmanager.com/LAMPAPI';

var extension = 'php';

var userId = 0;
var login = "";

function doRegister(){
    var Login = document.getElementById("Login").value;
    var Password = document.getElementById("Password").value;
    document.getElementById("addRegister").innerHTML = "";
    var tmp = {Login:Login,Password:Password};

	var jsonPayload = JSON.stringify( tmp );
	
	var url = urlBase + '/Register.' + extension;

	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");	

	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
               		document.getElementById("addRegister").innerHTML = "User added";	
			}
        
		};
		window.location.href = "ContactManager.html";
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("addRegister").innerHTML = "broke";
	}

}
function doLogin(){
    var Login = document.getElementById("Login").value;
    var Password = document.getElementById("Password").value;
    document.getElementById("loginStatus").innerHTML = "";
    var tmp = {Login:Login,Password:Password};
	
	
	var jsonPayload = JSON.stringify( tmp );
	
	
	var url = urlBase + '/UserLogin.' + extension;

	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");	
	
	try
	{

		xhr.onreadystatechange = function() {
			
			if (this.readyState == 4 && this.status == 200) 
			{
				var jsonObject = JSON.parse( xhr.responseText );
				
				userId = jsonObject.ID;
				localStorage.setItem("userId",userId);
               			if( userId < 1 )
				{		
				document.getElementById("loginStatus").innerHTML = "User/Password combination incorrect";
				return;
				}
				window.location.href = "ContactManager.html";
			
			}		
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("addLogin").innerHTML = "broke";
	}
	//createContactList();

}

function doLogout()
{
	userId = 0;
	window.location.href = "index.html";
}

function addContacts(){
    var FirstName = document.getElementById("FirstName").value;
    var LastName = document.getElementById("LastName").value;
    var PhoneNumber = document.getElementById("PhoneNumber").value;
    var Email = document.getElementById("Email").value;
    var userId = parseInt(localStorage.getItem("userId"));
    document.getElementById("contactResult").innerHTML = "";
	
	
    var tmp = {FirstName:FirstName,
		LastName:LastName,
		PhoneNumber:PhoneNumber,
		Email:Email, 
		UserID:userId
	};

	var jsonPayload = JSON.stringify( tmp );
	var url = urlBase + '/AddContact.' + extension;

	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{

			if (this.readyState == 4 && this.status == 200) 
			{	
               			document.getElementById("contactResult").innerHTML = "Contact added";	
			}
        
		};
		//window.location.href = "ContactManager.html";
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("contactResult").innerHTML = "broke";
	}
	addRow(FirstName, LastName,Email, PhoneNumber);


}


function addRow(firstName, lastName, email, phoneNumber) {
 
    var table = document.getElementById("myTableData");
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    row.insertCell(0).innerHTML= '<input type="button" value = "Delete" onClick="Javacsript:deleteRow(this)">';
    row.insertCell(1).innerHTML= firstName;    
    row.insertCell(2).innerHTML= lastName; 
    row.insertCell(3).innerHTML= email;
    row.insertCell(4).innerHTML= phoneNumber;
    row.insertCell(5).innerHTML= '<button onClick="update()">Edit</button>';    
}
 
function deleteRow(obj) {
    var index = obj.parentNode.parentNode.rowIndex;
    var table = document.getElementById("myTableData");
	
	
    var firstname = table.rows[index].cells[1].innerHTML;
    var lastname = table.rows[index].cells[2].innerHTML;
    var phone = table.rows[index].cells[3].innerHTML;
    var email = table.rows[index].cells[4].innerHTML;

	table.deleteRow(index);

		
    var tmp = {FirstName:firstname,
		LastName:lastname,
		PhoneNumber:phone,
		Email:email	};

	var jsonPayload = JSON.stringify( tmp );
	var url = urlBase + '/DeleteContact.' + extension;


	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{

			if (this.readyState == 4 && this.status == 200) 
			{	
              			}
        
		};
		//window.location.href = "ContactManager.html";
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		
	}
    
}

function update()
{
	alert("Hi");
}


function search()
{
    var Search = document.getElementById("Search").value;
    var userId = parseInt(localStorage.getItem("userId"));
	
	var tmp = { Search:Search,
                UserID:userId
            };
	var jsonPayload = JSON.stringify( tmp );

	var url = urlBase + '/SearchContact.' + extension;
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
								
              			  var jsonObject = JSON.parse( xhr.responseText );
               			 var table = document.getElementById("myTableData");
     
               			 var rowCount = table.rows.length;
               			 var row = table.insertRow(rowCount);
			
        
              			  
              			     for (var i = rowCount-1; i >= 0; i--)
               				 {
                 		   table.deleteRow(i);
               				 }          
               var jsonObject = JSON.parse( xhr.responseText );

               			 for (var i = 0; i < jsonObject.FirstNameList.length; i++)
              			  {
               				 var firstNameContact = jsonObject.FirstNameList[i];
               				 var lastNameContact = jsonObject.LastNameList[i];
               				 var emailContact = jsonObject.EmailList[i];
             				 var phoneNumberContact = jsonObject.PhoneList[i];
					 
					 addRow(firstNameContact, lastNameContact, phoneNumberContact,emailContact);
                                  }	
				
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("returnList").innerHTML = err.message;
	}
    
}
