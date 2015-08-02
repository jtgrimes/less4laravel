<?php namespace Jtgrimes\Less4laravel;

use Collective\Html\HtmlBuilder as Html;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Filesystem\Filesystem;
use Less_Parser;

class Less {
	private $config;
	private $filesystem;
	private $builder;
	private $compiled = false;

	public function __construct(Config $config, Filesystem $filesystem, Html $builder)
	{
		$this->config = $config;
		$this->builder = $builder;
		$this->filesystem = $filesystem;
	}

	public function to($filename, $attributes = array())
	{
		if (!$this->compiled) {
			$this->compileLess($filename);
		}
		$link = $this->link($filename);
		return $this->builder->style($link, $attributes);
	}

	public function link($filename)
	{
		if (!$this->compiled) {
			$this->compileLess($filename);
		}
		$linkFolder = $this->config->get('less4laravel.link_folder');
		return $linkFolder . '/' . $filename . '.css';
	}

	public function compileLess($filename)
	{
		$basePath = $this->getBasePath();
		$sourceFolder = $this->config->get('less4laravel.source_folder');
		$targetFolder = $this->config->get('less4laravel.target_folder');
		$inputFileName = "$basePath/$sourceFolder/$filename.less";
		$outputFileName = "$basePath/$targetFolder/$filename.css";

		$options = $this->buildOptions();
		$parser = new Less_Parser($options);

		$less = $this->filesystem->get($inputFileName);
		$parser->parse($less);
		$this->filesystem->put($parser->getCss(), $outputFileName);

		$this->compiled = true;
	}

	private function buildOptions()
	{
		$options['compress'] = $this->config->get('less4laravel.minify', false);

		$cacheFolder = $this->config->get('less4laravel.cache_folder');
		$options['cache_dir'] = $this->getBasePath().'/'.$cacheFolder;

		return $options;
	}

	private function getBasePath()
	{
		if (function_exists('base_path')) {
			return base_path();
		}
		return '';
	}
}
