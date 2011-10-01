<?php
/*
* This file is part of predb <gitgub.com/Rogiel/predb>.
*
* predb is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* predb is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with predb.  If not, see <http://www.gnu.org/licenses/>.
*/

// Require core library
require_once '../PreDatabase_Library.php';

/**
 * Adapter implementation for http://pre.scnsrc.net/
 * @author Rogiel
 * @since 1.0
 */
class Pre_ScnSrc_Adapter implements Pre_Adapter {
	public function latest() {
		$html = file_get_contents("http://pre.scnsrc.net/index.php");
		return $this->parseList($html);
	}

	public function search($release) {
		$html = $this->download(
				"http://pre.corrupt-net.org/search.php?search=" . $release);
		return $this->parseList($html);
	}

	private function parseList($html) {
			
		$dom = new DomDocument();
		$result = @$dom->loadHTML($html); //ignore parse errors
		$xpath = new DomXPath($dom);
			
		$i = 0;
		while (true) {
			$i ++;
			///html/body/table/tbody/tr[3]
			$node = $xpath->query(
					"/html/body/table/tr[" . $i . "]/td");
			if ($node->length == 0) {
				//die("empty!");
				break;
			}
			$pres[] = &$this->parseRelease($node);
		}
		return $pres;
	}

	/**
	 * @param DOMNodeList $node
	 */
	private function parseRelease($node) {
		//		$extra = $node->item(3)->nodeValue;
		//		if (strlen($extra)) {
		//			list ($size, $files) = explode("|", $extra);
		//			$size = trim($size);
		//			$files = trim($files);
		//		}
		$entry = &new Pre_Release();
		$entry->release = $node->item(1)->nodeValue;
		$entry->type = $node->item(0)->nodeValue;
		if ($node->length == 3) {
			$entry->date = strtotime(substr($node->item(2)->nodeValue, 4)) +
			$vbulletin->options['release_time_offset'];
		} else {
			$entry->size = (intval($node->item(2)->nodeValue)) * 1024 *
			1024; //as bytes
			$entry->files = intval($files);
		}

		return $entry;
	}

	private function download($url) {
		$options = array(
		CURLOPT_RETURNTRANSFER => true,  // return web page
		CURLOPT_HEADER => false,  // don't return headers
		CURLOPT_FOLLOWLOCATION => true,  // follow redirects
		CURLOPT_HEADER => array(
							'Host: pre.corrupt-net.org', 
		//'Accept: text/html,application/xhtml+xml,application/xml;q=0.9;q=0.8',
							'User-Agent: Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.15) Gecko/20110303 Ubuntu/10.10 (maverick) Firefox/3.6.15', 
							'Accept-Language: en-us,en;q=0.5', 
							'Accept-Encoding: gzip,deflate', 
							'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7', 
							'Keep-Alive: 115', 
							'Connection: keep-alive', 
							'Cache-Control: max-age=0'), 
		//CURLOPT_USERAGENT => "Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.15) Gecko/20110303 Ubuntu/10.10 (maverick) Firefox/3.6.15",  // who am i
		//CURLOPT_AUTOREFERER => true,  // set referer on redirect
		CURLOPT_CONNECTTIMEOUT => 120,  // timeout on connect
		CURLOPT_TIMEOUT => 120,  // timeout on response
		CURLOPT_MAXREDIRS => 10); // stop after 10 redirects


		$ch = curl_init($url);
		curl_setopt_array($ch, $options);
		$content = curl_exec($ch);
		$err = curl_errno($ch);
		$errmsg = curl_error($ch);
		$header = curl_getinfo($ch);
		curl_close($ch);

		$header['errno'] = $err;
		$header['errmsg'] = $errmsg;
		$header['content'] = $content;

		print_r($header);
		die();
		return $content;
	}
}

?>