<?php namespace Jtgrimes\Less4laravel;

use Collective\Html\HtmlBuilder as Html;
use Illuminate\Contracts\Config\Repository as Config;
use Less_Parser;

class Less {
	private $config;
	private $builder;
	private $compiled = false;

	public function __construct(Config $config, Html $builder)
	{
		$this->config = $config;
		$this->builder = $builder;
	}

	public function to($filename, $attributes = array())
	{
		if (!$this->compiled && $this->needsCompile($filename)) {
			$this->compileLess($filename);
		}
		$link = $this->link($filename);
		return $this->builder->style($link, $attributes);
	}

	public function link($filename)
	{
		if (!$this->compiled && $this->needsCompile($filename)) {
			$this->compileLess($filename);
		}
		$linkFolder = $this->config->get('less4laravel.link_folder');
		return $linkFolder . '/' . $filename . '.css';
	}

	public function compileLess($filename)
	{
		$sourceFolder = $this->config->get('less4laravel.source_folder');
		$targetFolder = $this->config->get('less4laravel.target_folder');
		$inputFileName = base_path("$sourceFolder/$filename.less");
		$outputFileName = base_path("$targetFolder/$filename.css");

		$options = $this->buildOptions();
		$parser = new Less_Parser($options);

		$parser->parseFile($inputFileName, '');
		file_put_contents($outputFileName, $parser->getCss());

		$this->compiled = true;
	}

	private function buildOptions()
	{
		$options['compress'] = $this->config->get('less4laravel.minify', false);

		$cacheFolder = $this->config->get('less4laravel.cache_folder');
		$options['cache_dir'] = base_path($cacheFolder);

		return $options;
	}

	private function needsCompile($filename)
	{
		//TODO: needsCompile is a stub for figuring out how to set compile frequency.
		return true;
	}

}
