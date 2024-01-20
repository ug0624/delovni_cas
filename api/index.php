<?php
// Redirect to the main application or display an access denied message
header("HTTP/1.1 403 Forbidden");
echo "Access Forbidden. You don't have permission to access this directory.";
