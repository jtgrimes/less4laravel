<?php namespace Jtgrimes\Less4laravel;

use lessc;
use Illuminate\Config\Repository as Config;
use Illuminate\Html\HtmlBuilder as Html;

class Less {
	var $config;
	var $builder;

	public function __construct(Config $config, Html $builder) {
		$this->config = $config;
		$this->builder = $builder;
	}

	public function to($filename, $attributes=array()) {
		$compiler = new lessc;
        $compiler->setFormatter($this->config->get('less4laravel::formatter','lessjs'));
		$basePath = base_path();
		$sourceFolder = $this->config->get('less4laravel::source_folder');
		$targetFolder = $this->config->get('less4laravel::target_folder');
		$in = "$basePath/$sourceFolder/$filename.less";
		$out = "$basePath/$targetFolder/$filename.css";
		switch($this->config->get('less4laravel::compile_frequency')) {
			case "all":
				$compiler->compileFile($in, $out);
				break;
			case "changed":
                $compiler->checkedCompile($in, $out);
				break;
			case "none":
			default:
				// do nothing
		}
		$linkFolder = $this->config->get('less4laravel::link_folder');
		return $this->builder->style("$linkFolder/$filename.css",$attributes);
	}
}