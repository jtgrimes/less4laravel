<?php namespace Jtgrimes\Less4laravel;

use lessc;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class Less {
	public function to($filename) {
		$compiler = new lessc;
		$root = App::make('path')."/../";
		$in = $root.Config::get('less4laravel::source_folder')."/".$filename.".less";
		$out = $root.Config::get('less4laravel::target_folder')."/".$filename.".css";
        $link= Config::get('less4laravel::link_folder')."/".$filename.".css";
		switch(Config::get('less4laravel::compile_frequency')) {
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
		return '<link rel="stylesheet" href="'.$link.'">';
	}
}