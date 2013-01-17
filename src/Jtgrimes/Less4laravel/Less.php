<?php namespace jtgrimes\Less4laravel;

use lessc;
use Illuminate\Support\Facades\App;

class Less {
	function less($filename) {
		$compiler = new lessc;
		$root = App::make('path')."/../";
		$in = $root.Config::get('less4laravel::source')."/".$filename.".less";
		$out = $root.Config::get('less4laravel::target')."/".$filename.".css";
		switch(Config::get('less4laravel::compile_frequency')) {
			case "all":
				lessc->compileFile($in, $out);
				break;
			case "changed":
				lessc->checkedCompile($in, $out);
				break;
			case "none":
			default:
				// do nothing
		}
		return '<link rel="stylesheet" href="'.$out.'">';
	}
}