<?php
/*
 * @file init
 * loads all the extensions for easily extended wordpress themes with
 *
 * - custom post types
 * - meta boxes
 * - theme options
 */
include_once "controller/post-types.php";
include_once "controller/theme-options.php";
include_once "controller/validators.php";

include_once "view/fields.php";

?>