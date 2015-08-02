<?php namespace Jtgrimes\Less4laravel;

use Collective\Html\HtmlBuilder as Html;
use Illuminate\Contracts\Config\Repository as Config;
use lessc;

class Less {
	var $config;
	var $builder;

	public function __construct(Config $config, Html $builder) {
		$this->config = $config;
		$this->builder = $builder;
	}

	public function to($filename, $attributes = array()) {
		$link = $this->link($filename, $attributes);
		return $this->builder->style($link, $attributes);
	}

	public function link($filename, $attributes = array()) {
		$compiler = new lessc;
		$compiler->setFormatter($this->config->get('less4laravel.formatter', 'lessjs'));
		$basePath = base_path();
		$sourceFolder = $this->config->get('less4laravel.source_folder');
		$targetFolder = $this->config->get('less4laravel.target_folder');
		$cacheFolder = $this->config->get('less4laravel.cache_folder');
		$in = "$basePath/$sourceFolder/$filename.less";
		$out = "$basePath/$targetFolder/$filename.css";
		$cache = "$basePath/$cacheFolder/$filename.less.cache";
		switch ($this->config->get('less4laravel.compile_frequency')) {
			case "all":
				$compiler->compileFile($in, $out);
				break;
			case "changed":
				$compiler->checkedCompile($in, $out);
				break;
			case "cached":
			/*
			From Lessphp docs: For this reason we also have cachedCompile. It’s slightly more complex, but gives us the ability to check changes to all files including those imported. It takes one argument, either the name of the file we want to compile, or an existing cache object. Its return value is an updated cache object.
			J.T. says: seriously? the same variable used for two totally different things? I hate this.
			*/
				if (file_exists($cache)) {
					$cacheData = unserialize(file_get_contents($cache));
				} else {
					$cacheData = $in;
				}
				$newCache = $compiler->cachedCompile($cacheData);
				if (!is_array($cacheData) || $newCache["updated"] > $cacheData["updated"]) {
					file_put_contents($cache, serialize($newCache));
					file_put_contents($out, $newCache['compiled']);
				}
				break;
			case "none":
			default:
				// do nothing
		}
		$linkFolder = $this->config->get('less4laravel.link_folder');
		return $linkFolder . '/' . $filename . '.css';
	}
}
