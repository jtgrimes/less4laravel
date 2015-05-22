<?php namespace Jtgrimes\Less4laravel;

use lessc;
use Illuminate\Contracts\Config\Repository as Config;
use Collective\Html\HtmlBuilder as Html;

class Less {
	var $config;
	var $builder;

	public function __construct(Config $config, Html $builder) {
		$this->config = $config;
		$this->builder = $builder;
	}

	public function to($filename, $attributes=array()) {
		$compiler = new lessc;
        $compiler->setFormatter($this->config->get('less4laravel.formatter','lessjs'));
		$basePath = base_path();
		$sourceFolder = $this->config->get('less4laravel.source_folder');
		$targetFolder = $this->config->get('less4laravel.target_folder');
		$caheFolder = $this->config->get('less4laravel.cahce_folder');
		$in = "$basePath/$sourceFolder/$filename.less";
		$out = "$basePath/$targetFolder/$filename.css";
		$cache = "$basePath/$caheFolder/$filename.less.cache";
		switch($this->config->get('less4laravel.compile_frequency')) {
			case "all":
				$compiler->compileFile($in, $out);
				break;
			case "changed":
                $compiler->checkedCompile($in, $out);
				break;
			case "cached":
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
		return $this->builder->style("$linkFolder/$filename.css",$attributes);
	}
}
