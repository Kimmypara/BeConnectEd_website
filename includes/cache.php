<?php
    // include this in your html before the <html> tag
    header("Cache-Control: no-cache, must-revalidate"); // does not store the page in cache
    header("Expires: 01 Jan 1970 00:00"); // Date in the past to cancel cache
?>