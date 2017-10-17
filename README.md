# Autoloader

Class to autoload class of course. I use in my projects and it works the way I need it.

Examples: 
```php
require_once __DIR__.'/classes/Treto/Loader.php';
$Loader =  new Loader;
$Loader -> register([
	'../vendor',
	'../otherClass/folder/' //optional
]);
```