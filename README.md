# Autoloader

Class to autoload class of course. I use in my projects and it works the way I need it.

Examples: 
```php
require_once __DIR__.'/classes/Treto/Loader.php';
$Loader =  new Loader;

//multi destination folder with classes
$Loader -> register([
	'../classes',
	'../vendor', 
	'../otherClass/folder/'
]);
```