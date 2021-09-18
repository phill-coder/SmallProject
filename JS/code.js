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
	alert(jsonPayload);
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

}

