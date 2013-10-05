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

/**
* Adapter implementation for http://orlydb.com/
* @author <a href="http://www.rogiel.com/">Rogiel</a>
* @since 1.0
*/
class Pre_Orlydb_Adapter implements Pre_Adapter {
	public function latest() {
		$html = file_get_contents("http://orlydb.com/1");
		return $this->parseList($html);
	}

	public function search($release) {
		$html = file_get_contents("http://orlydb.com/?q=" . urlencode($release));
		return $this->parseList($html);
	}

	private function parseList($html) {
		$dom = new DomDocument();
		$result = @$dom->loadHTML($html); //ignore parse errors
		$xpath = new DomXPath($dom);

		$i = 0;
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
	 * @param DOMNodeList $node
	 */
	private function parseRelease($node) {
		$extra = $node->item(3)->nodeValue;
		if (strlen($extra)) {
			list ($size, $files) = explode("|", $extra);
			$size = trim($size);
			$files = trim($files);
		}
		$entry = new Pre_Release();
		$entry->release = $node->item(2)->nodeValue;
		$entry->type = $node->item(1)->nodeValue;
		$entry->date = strtotime($node->item(0)->nodeValue);
		$entry->size = (intval($size)) * 1024 * 1024; //as bytes
		$entry->files = intval($files);
		$entry->nuke = $node->item(4)->nodeValue;
			
		return $entry;
	}
}
?>