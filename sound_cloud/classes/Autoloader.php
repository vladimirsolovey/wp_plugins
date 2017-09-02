<?php
/**
 * Date: 22.08.17
 * Time: 15:48
 */

namespace SoundCloud\classes;


class HF_Autoloader {


	public static $instance;

	private $prefixes = array();

	public static function getInstance()
	{
		if(!self::$instance instanceof HF_Autoloader)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function register_autoloader()
	{
		spl_autoload_register(array($this,'init_autoload'));
	}

	public function init_autoload($class)
	{
		$class_name = $this->getClassPath($class);
		if(!empty($class_name))
		{
			include_once($class_name);
		}
	}

	public function getClassPath($class)
	{
		foreach ( $this->prefixes as $prefix=>$dir  ) {
			if(preg_match('/^'.$prefix.'/',$class,$match)!=1)
			{
					continue;
			}
			$class = preg_replace("/\\\\/",'/',$class);
			$class_name = preg_replace('/^'.$prefix.'/',$dir,$class).'.php';
			if(!file_exists($class_name))
			{
				continue;
			}
			return $class_name;
		}
		return false;
	}

	public function setPrefixes(array $path_to_classes)
	{
			foreach($path_to_classes as $prefix=>$dir)
			{
				$this->setPrefix($prefix,$dir);
			}
	}

	private function setPrefix($prefix,$dir)
	{
			$dir = rtrim($dir,'/');
		if(!isset($this->prefixes[$prefix]))
		{
			$this->prefixes[$prefix]=array();
		}
		$this->prefixes[$prefix] = $dir;
	}



}