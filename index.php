<?php
// Initialize Papirus System
require_once dirname(__FILE__) . "/library/bootstrap.php";


// Content Module Test
require_once dirname(__FILE__) . "/module/Content/class.content.php";

// Render Content Test Module
$module_content = new Module_Content($papirus);
print $module_content -> render();

