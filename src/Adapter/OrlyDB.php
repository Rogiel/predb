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
namespace PreDB\Adapter;

use PreDB\Release;
use DOMDocument;
use DOMXPath;
use DateTime;
use DateTimeZone;

/**
 * Adapter implementation for http://orlydb.com/
 *
 * @author <a href="http://www.rogiel.com/">Rogiel</a>
 * @since 1.0
 *       
 */
class OrlyDB implements Adapter {

	public function latest($page = 1) {
		$html = file_get_contents("http://orlydb.com/" . $page);
		return $this->parseList($html);
	}

	public function search($release, $page = 1) {
		$html = file_get_contents("http://orlydb.com/{$page}?q=" . urlencode($release));
		return $this->parseList($html);
	}

	private function parseList($html) {
		$dom = new DOMDocument();
		@$dom->loadHTML($html); // ignore parse errors
		$xpath = new DOMXPath($dom);
		
		$i = 0;
		
		$pres = array();
		while (true) {
			$i ++;
			$node = $xpath->query("/html/body/div/div[2]/div[" . $i . "]/span");
			if ($node->length == 0)
				break;
			$pres[] = $this->parseRelease($node);
		}
		return $pres;
	}

	/**
	 *
	 * @param DOMNodeList $node        	
	 */
	private function parseRelease($node) {
		$extra = $node->item(3)->nodeValue;
		if (strlen($extra)) {
			list ($size, $files) = explode("|", $extra);
			$size = trim($size);
			$files = trim($files);
		}
		$entry = new Release();
		$entry->release = $node->item(2)->nodeValue;
		$entry->type = $node->item(1)->nodeValue;
		$entry->date = new DateTime($node->item(0)->nodeValue, new DateTimeZone('UTC'));
		$entry->size = (intval($size)) * 1024 * 1024; // as bytes
		$entry->files = intval($files);
		$entry->nuke = $node->item(4)->nodeValue;
		
		return $entry;
	}
}
?>