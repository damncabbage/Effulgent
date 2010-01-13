<?php
	// Just the mock I created the templates from.

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>SMASH! Ticketbooth</title>
	<link href="css/styles.css" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#query').focus();
		});
	</script>
	
</head>
<body>

	<div id="header">
		<h1><a href="/">SMASH! Ticketbooth</a></h1>
		<ul>
			<li class="first">Welcome, Ticketbooth1 (<a href="/user/logout">Logout</a>)</li>
			<li>Processed <strong>300</strong> of <strong>900</strong></li>
		</ul>
	</div>

	<div id="main">
		<ul class="instructions">
			<li><span class="number">1.</span> Scan a ticket, or type in a name.</li>
			<li><span class="number">2.</span> Choose a ticket entry.</li>
			<li><span class="number">3.</span> Do these details match the name on their ticket,<br/>
			    <span class="number">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>or on their ID if they don't have a ticket?<br />
				<span class="number">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>(Call for help if they don't.)</li>
		</ul>

		<div class="search-container">
			<form action="/tickets/search" method="get">
				<input id="query" name="query" class="text" type="text" value="" />
				<input name="search" class="submit" type="submit" value="Go!" />
			</form>
		</div>

		<div class="ticket-details-container">
			<dl>
				<dt>Reg. ID</dt><dd>SM000123</dd>
				<dt>Full Name</dt><dd>Rob Howard</dd>
				<dt>Age</dt><dd>25</dd>
				<dt>Sex</dt><dd>Male</dd>
				<dt>Address</dt><dd>Here and There</dd>
			</dl>
			<form action="/tickets/scan" method="post">
				<div class="button-container">
					<input class="confirm" name="confirm" type="submit" value="Yes" />
					<input class="cancel" name="cancel" type="submit" value="No" />
				</div>
			</form>
		</div>

		<div class="ticket-details-container">
			<a href="/tickets/search?query=SM000123">
				<dl>
					<dt>Reg. ID</dt><dd>SM000123</dd>
					<dt>Full Name</dt><dd>Rob Howard</dd>
					<dt>Age</dt><dd>25</dd>
					<dt>Sex</dt><dd>Male</dd>
					<dt>Address</dt><dd>Here and There</dd>
				</dl>
				<br class="clear" />
			</a>
		</div>

		<div class="ticket-details-container">
			<a href="/tickets/search?query=SM000123">
				<dl>
					<dt>Reg. ID</dt><dd>SM000123</dd>
					<dt>Full Name</dt><dd>Rob Howard</dd>
					<dt>Age</dt><dd>25</dd>
					<dt>Sex</dt><dd>Male</dd>
					<dt>Address</dt><dd>Here and There</dd>
				</dl>
				<br class="clear" />
			</a>
		</div>

		<br class="clear" />
	</div>

	<div id="footer">
		<p>Copyright &copy; SMASH! 2009</p>
	</div>

</body>
</html>
