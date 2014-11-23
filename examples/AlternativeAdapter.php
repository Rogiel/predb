<?php
/*
 * Copyright (c) 2014, Rogiel Sulzbach <rogiel@rogiel.com>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 * notice, this list of conditions and the following disclaimer in the
 * documentation and/or other materials provided with the distribution.
 * 3. All advertising materials mentioning features or use of this software
 * must display the following acknowledgement:
 * This product includes software developed by Rogiel Sulzbach.
 * 4. Neither the name of the <organization> nor the
 * names of its contributors may be used to endorse or promote products
 * derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY ROGIEL SULZBACH ''AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL ROGIEL SULZBACH BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
namespace PreDB\Example;

require_once __DIR__ . '/../autoload.php';

use PreDB\PreDB;
use PreDB\Release;

// This example does a simple search for an pre release

/**
 * Implements a custom adpater
 */
class MyCustomAdapter implements \PreDB\Adapter\Adapter {

	/**
	 * Implements the underlying search method
	 *
	 * @param string $release        	
	 */
	function search($release) {
		return NULL; // no search allowed
	}

	/**
	 * Implements the underlying latest method
	 */
	function latest() {
		return [
			new Release([
				'release' => 'My.Awesome.Release-AWESOME',
				'size' => 1 * 1024
			])
		];
	}
}

$db = new PreDB(new MyCustomAdapter());
print_r($db->latest());
?>