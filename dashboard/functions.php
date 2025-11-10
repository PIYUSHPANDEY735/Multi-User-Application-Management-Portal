<?php

function safe_name($label) {
    // Convert label to lowercase, replace spaces and remove special characters
    $safe = strtolower($label);
    $safe = preg_replace('/[^a-z0-9_]/', '_', $safe);  // Replace non-alphanum with underscore
    $safe = preg_replace('/_+/', '_', $safe);          // Replace multiple underscores with single
    $safe = trim($safe, '_');                          // Trim leading/trailing underscores
    return $safe;
}


?>