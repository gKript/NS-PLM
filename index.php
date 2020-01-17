<!--
|
|	File: index.php
|
|	Next Step ID  -  Product Lifecycle Management
|	Danilo Zannoni
|	V 00.001
|	Code: 53E0000100
|
-->

<?php
	$nspage = "index";

	require_once 'includes.php';
	
	require_once NSID_PLM_SRC_TEMPLATE . 'code_functions.php';
	require_once NSID_PLM_SRC_TEMPLATE . 'index_funtions.php';
	
?>


<?php

	include NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
		
?>

<div class="insidecodelite">
<div class="codelite">
<h3>Welcome to NS-PLM</h3>
<img src="src/img/logo/ns.png" border="0" alt="nsplm logo" style="max-width: 20%; float: right; padding-right: 30px;" />
<p>
This page has been designed to start the activities.
<br/>
You can start clicking a code from the table below or searching something.
<br/>
The menu above is the best tool to use NS-PLM.
<br/>
<br/>
Good work.
</p>
</div>
</div>

	
<?php
	include NSID_PLM_SRC_TEMPLATE . 'footer.php';
	$mysqli->close();
?>

