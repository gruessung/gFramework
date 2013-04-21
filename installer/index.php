<!doctype html>
<html lang="en">
<head>
	<title>gVisions Installer</title>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<style>body{padding-top: 60px;}</style>
	<link href="./bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="./bwizard.min.css" rel="stylesheet" />
</head>
<body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="#">gVisions Installer</a>
        </div>
      </div>
    </div>

	<div class="container">
		<h2>gFramework</h2>
		<div id="msg">
		</div>
		<div id="wizard">
			<ol>
				<li>Willkommen</li>
				<li>Lizens</li>
				<li>Datenbank</li>
				<li>Administrator</li>
				<li>Fertig</li>
			</ol>
			<div>
				<p>Willkommen im gVisions Installer zur Installation von gFramework.</p>
				<p>Der Assistent wird Sie durch die Installation leiten und ein paar Daten abfragen.</p>
				<p>Wenn Sie fortfahren m&ouml;chten, klicken Sie auf "Weiter".</p>
			</div>
			
			<div>
				<p>Lesen Sie sich die Lizenz durch. Wenn Sie mit dieser Einverstanden sind, klicken Sie auf "Weiter".</p>
				<p><iframe src="../gplv3.txt" style="width:100%;" height="500"></iframe></p>
			</div>
			
			<div>

				<p>Geben Sie bitte Ihre Datenbankdaten an.<p>
				<p><b>Beachten Sie:</b> Die Datenbank muss bereits angelegt sein.</p>
				<br />
				
					<legend>Datenbankserver:</legend><input type="text" id="host" value="localhost"/>
					<legend>Datenbankuser:</legend><input type="text" id="user" />
					<legend>Datenbankpasswort:</legend><input type="text" id="pass" />
					<legend>Datenbank:</legend><input type="text" id="db" />
					<legend>Tabellenpr&auml;fix:</legend><input type="text" id="prafix" value="gframework_"/>
				
			</div>
			
			<div>
				<p>Geben Sie bitte die Daten f&uuml;r den ersten Administratoraccoount an.<p>
				<p><i>Es ist ratsam diesen Account nur f&uuml; administrative Zwecke zu nutzen und einen zweiten Nutzer mit normalen Rechten einzurichten.</i></p>	
				<br />
				
					<legend>Username:</legend><input type="text" id="auser" />
					<legend>Passwort:</legend><input type="text" id="apass" />
					<legend>E-Mail:</legend><input type="text" id="amail" />
			</div>
			<div>
				<h2>Herzlichen Gl&uuml;ckwunsch!</h2>
				Ihre neue Seite ist <a href="../index.php">online.</a>
				<p><b>Bitte l&ouml;schen Sie den Ordner "installer".</b></p>
			</div>
		</div>
	</div>

	<script src="./js/jquery.min.js"></script>
	<script src="./bootstrap/js/bootstrap.min.js"></script>
	<script src="./js/bwizard.js" type="text/javascript"></script>
	<script type="text/javascript">
	   $("#wizard").bwizard({ 
			validating: function (e, ui) 
			{
				switch (ui.index)
				{
					case 0:
					break;
					
					case 1:
					break;
					
					//DB Validation
					//wenn alles richtig, Tabellen anlegen
					case 2:
						var host = $("#host").attr("value");
						var user = $("#user").attr("value");
						var pass = $("#pass").attr("value");
						var db = $("#db").attr("value");
						var prafix = $("#prafix").attr("value");
						
						if (host.length==0) 
						{
							$("#host").attr("value", "REQUIRED");
							$("#wizard").bwizard("cancel");	
						}
						
						if (user.length==0) 
						{
							$("#user").attr("value", "REQUIRED");
							$("#wizard").bwizard("cancel");	
						}
						
						
						if (db.length==0) 
						{
							$("#db").attr("value", "REQUIRED");
							$("#wizard").bwizard("cancel");	
						}
						
						if (prafix.length==0) 
						{
							$("#prafix").attr("value", "REQUIRED");
							$("#wizard").bwizard("cancel");	
						}
						
						$.ajax({
							url: "./insertDB.php",
							data: {host: host, user:user, pass:pass, db:db, prafix:prafix},
							datatype: "json",
							async:false,
							type: "POST",
							success: function(data) 
							{  
								content = data.split("#");
								if (content[0].trim()=="ERROR")
								{
									$("#msg").html('<div class="alert alert-error"><b>Es ist ein Fehler aufgetereten!</b><br><br>'+content[1]+'</div>');
									$("#wizard").html("<a href=\"index.php\">Beginnen Sie von vorn.</a>");

								}
								else
								{
									$("#msg").html('<div></div>');
								}
							}
					   });
						
					break;
					
					//Admin Validation
					case 3:
						var email = $("#amail").attr("value");
						var user = $("#auser").attr("value");
						var pass = $("#apass").attr("value");

						
						if (user.length==0) 
						{
							$("#auser").attr("value", "REQUIRED");
							$("#wizard").bwizard("cancel");	
						}
						
						if (pass.length==0) 
						{
							$("#apass").attr("value", "REQUIRED");
							$("#wizard").bwizard("cancel");	
						}
						
						if (email.length==0) 
						{
							$("#amail").attr("value", "REQUIRED");
							$("#wizard").bwizard("cancel");	
						}

						$.ajax({
							url: "./insertAdmin.php",
							data: {user:user, pass:pass, email:email},
							datatype: "json",
							async:false,
							type: "POST",
							success: function(data) 
							{  
								content = data.split("#");
								if (content[0].trim()=="ERRORADMIN")
								{
									$("#msg").html('<div class="alert alert-error"><b>Es ist ein Fehler aufgetereten!</b><br><br>'+content[1]+'</div>');
									$("#wizard").html("<a href=\"index2.php\">Beginnen Sie von vorn.</a>");

								}
								else
								{
									$("#msg").html('<div></div>');
								}
							}
						});
						
					break;
					
					case 4:
					break;
				}
			}
		});
		
		function back()
		{
			$("#wizard").bwizard("back");	
		}
	</script>
</body>
</html>
