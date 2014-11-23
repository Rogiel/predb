<?php
/*
 * Copyright (c) 2014, Rogiel Sulzbach
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice, this
 * list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
spl_autoload_register(
	function ($class) {
		// the package namespace
		$ns = 'PreDB';
		
		// what prefixes should be recognized?
		$prefixes = array(
			"{$ns}\\" => array(
				__DIR__ . '/src'
			)
		);
		
		// go through the prefixes
		foreach ($prefixes as $prefix => $dirs) {
			// does the requested class match the namespace prefix?
			$prefix_len = strlen($prefix);
			if (substr($class, 0, $prefix_len) !== $prefix) {
				continue;
			}
			
			// strip the prefix off the class
			$class = substr($class, $prefix_len);
			
			// a partial filename
			$part = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
			
			// go through the directories to find classes
			foreach ($dirs as $dir) {
				$dir = str_replace('/', DIRECTORY_SEPARATOR, $dir);
				$file = $dir . DIRECTORY_SEPARATOR . $part;
				if (is_readable($file)) {
					require $file;
					return;
				}
			}
		}
	});
