<?php
/*
 * @file init
 * @version 1.0.2
 * loads all the extensions for easily extended wordpress themes with
 *
 * - custom post types
 * - meta boxes
 * - theme options
 */

require_once "config.php";

require_once "controller/post-types.php";
require_once "controller/taxonomies.php";
require_once "controller/sources.php";
require_once "controller/theme-options.php";
require_once "controller/validators.php";

require_once "view/fields.php";

?>