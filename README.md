# AgriLife Social Media Client

Version: 1.0

## Description

Pulls registered social media accounts from agrilife.org/communications and displays them in a widget or shortcode.

## Installation

1. Un-zip the contents into your WordPress plugin directory
2. Add the following lines to your wp-config.php

```php
/** XML-RPC settings ***/
define('XMLRPC_USER', 'Your username' );
define('XMLRPC_PASS', 'Your password' );
```