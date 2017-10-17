<?php
use Treto\FakeClass;
/*
    Autoloader by Tomirad Trela
    v.T3.2017.10.17

*/
class Loader {
	public $rootdir = [];
	protected $loaded_classes = [];
    private $debug = [];
    private $accessExtensions = ".php,.class.php";
	public function register($root, $prepend = false) {
		$this->setVendorDir($root);
		spl_autoload_extensions($this -> accessExtensions);
		spl_autoload_register( [$this, 'loadClass'], true, (bool) $prepend);
    }

    public function showDebug() {
        return $this->debug;
    }

    public function showClasses() {
        return $this->loaded_classes;
    }

    public function loadClass($class) {
		try {
	    	$class = $this->explodeClass($class);
	    	if(!class_exists($class -> name, false)) {
		    	foreach ($this->rootdir as $src) {
					if($this->findFile($src.$class -> src, $class -> name)) {
						$file = $this->getFileSrc();
						break;
					}
		    	}
	    		if($file??false) {
					$this->requireFile($file);
					$this->loaded_classes[$class -> name] = $file;
					$this->debug[] = '<br>- class exist '.$src.$class -> src;
				} else {
					class_alias ( 'FakeClass', $class -> namespace);
					$this->debug[] = "<br>- Class `{$class->name}` not exist in file ".$src.$class -> src;
					//echo "\n<br>- Class [".__NAMESPACE__."] `{$class->name}` not exist in file ".$src.$class -> src;
					// throw new \Exception("Class not exist: ". $class -> name);
					//header('HTTP/1.0 404 Not Found', true, 404);
				}	
		    }

		} catch (\Exception $exception) {
			echo $exception->getMessage();
		}
    }

    private function explodeClass($class) {
    	$obj = new \stdClass;
        $obj -> namespace = $class;
    	$file = explode('\\', $class);
    	$obj -> name = end($file);
    	$file = array_splice($file, 0, -1);
        $obj -> src = '';
    	foreach ($file as $k) {
    		$obj -> src .= '/'.$k;
    	}
    	return $obj;
    }

    private function findFile($dir, $nameclass) {
    	if(file_exists($dir.'/'.$nameclass.'.php')) {
    		$this->class_src = $dir.'/'.$nameclass.'.php';
    		return true;
    	} elseif(file_exists($dir.'/'.$nameclass.'.class.php')) {
    		$this->class_src = $dir.'/'.$nameclass.'.class.php';
    		return true;
    	} elseif(file_exists($dir.'/class.'.$nameclass.'.php')) {
    		$this->class_src = $dir.'/class.'.$nameclass.'.php';
    		return true;
    	} else {
    		return false;
    	}
    }

    private function getFileSrc() {
    	return $this->class_src;
    }

    private function setVendorDir($root) {
    	if(is_array($root)) {
    		$this->rootdir = array_merge($this->rootdir, $root);
    	} else {
	    	$this->rootdir[] = $root;
	    }
    }

    protected function requireFile($file) {
        if (file_exists($file)) {
            require $file;
            return true;
        }
        return false;
    }
}
?>