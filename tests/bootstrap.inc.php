<?php

// Define the key
define('API_KEY', '6316849-782962b5b451c1754a12aa720');

// Initialize
\Intellex\Debugger\IncidentHandler::register();
function debug($data) {
	\Intellex\Debugger\VarDump::from($data, 0);
}
