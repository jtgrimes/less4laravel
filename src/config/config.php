<?php
return array(
    /*
    |--------------------------------------------------------------------------
    | Compilation frequency
    |--------------------------------------------------------------------------
    |
    | This option controls how often your less files are (re)compiled
    | Possible values:
    |    all: 		re-compile less files every time.
    |				Generally, use only when developing .less files
    |    changed:	re-compile when less files are changed.
    |				Generally, use this option if your less files don't 
	|				include other files
    |    cached:    re-compile when any imported less files are changed.
    |				Generally, use this during most development
    |	 never:		do not re-compile less files
    |				Generally, use this in production.  Once you've got your css
    |				files generated, don't change them in production
    |
    */
    'compile_frequency' => 'cached',

    /*
    |--------------------------------------------------------------------------
    | Source folder
    |--------------------------------------------------------------------------
    |
    | Where should we look for .less files?
    | default: resources/assets/less
    */
    'source_folder' => 'resources/assets/less',

    /*
    |--------------------------------------------------------------------------
    | Target folder
    |--------------------------------------------------------------------------
    |
    | Where should we save compiled css files?
    | default: public/css
    */
    'target_folder' => 'public/css',

    /*
    |--------------------------------------------------------------------------
    | Cache folder
    |--------------------------------------------------------------------------
    |
    | Where should we save cache file?
    | default: storage/framework/cache
    */
    'cache_folder' => 'storage/framework/cache',

    /*
    |--------------------------------------------------------------------------
    | Link folder
    |--------------------------------------------------------------------------
    |
    | When we generate a link to the css file, where should it point?
    | default: /css
    */
    'link_folder' => '/css',

    /*
    |--------------------------------------------------------------------------
    | Mininify
    |--------------------------------------------------------------------------
    |
	| This option controls the formatting of the output css file
	| Possible values:
	|    true:	 Strip comments and whitespace out of the output file
	|    false:  Include comments and whitespace in the output
    | default: false
    */
    'minify' => false,


);
