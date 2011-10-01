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
 * The pre database communication class. All operations are performed trough this class.
 * @author <a href="http://www.rogiel.com/">Rogiel</a>
 * @since 1.0
 */
class Pre_DB {
	/**
	 * The Pre_Adapter implementation
	 * @var Pre_Adapter
	 */
	private $adapter;

	/**
	 * Creates a new instance
	 * @param Pre_Adapter $adapter  the adapter to use. If none is provided an default is used.
	 */
	public function __construct($adapter = null) {
		if ($adapter == null) {
			require_once 'Adapter/Pre_Orlydb_Adapter.php';
			$adapter = new Pre_Orlydb_Adapter();
		}
		$this->adapter = $adapter;
	}

	/**
	 * Searches the pre database for certain releases
	 * @param string, Pre_SearchHelper $query the query
	 */
	public function search($query) {
		if ($query instanceof Pre_SearchHelper) {
			$query = $query->getSearchQuery();
		}
		return $this->adapter->search($query);
	}

	/**
	 * Searches the pre database for an certain release
	 * @param string $release the release name
	 * @return Pre_Release
	 */
	public function get($release) {
		$releases = $this->adapter->search($release);
		return predb_find_suitable_release($release, $releases);
	}

	/**
	 * Retrieve the latest pre entries from the database
	 */
	public function latest() {
		return $this->adapter->latest();
	}
}

/**
 * Pre entry
 * @author @author <a href="http://www.rogiel.com/">Rogiel</a>
 * @since 1.0
 */
class Pre_Release {
	/**
	 * @var string
	 */
	var $release;
	/**
	 * @var string
	 */
	var $type;
	/**
	 * @var int
	 */
	var $date;
	/**
	 * @var int
	 */
	var $size;
	/**
	 * @var int
	 */
	var $files;
	/**
	 * @var string
	 */
	var $nuke;

	/**
	 * @return the $release
	 */
	public function getRelease() {
		return $this->release;
	}

	/**
	 * @return the $date
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @return the $size
	 */
	public function getSize() {
		return $this->size;
	}

	/**
	 * @return the $files
	 */
	public function getFiles() {
		return $this->files;
	}

	/**
	 * @return the $nuke
	 */
	public function getNuke() {
		return $this->nuke;
	}

	/**
	 * @param string $release
	 */
	public function setRelease($release) {
		$this->release = $release;
	}

	/**
	 * @param int $date
	 */
	public function setDate($date) {
		$this->date = $date;
	}

	/**
	 * @param int $size
	 */
	public function setSize($size) {
		$this->size = $size;
	}

	/**
	 * @param int $files
	 */
	public function setFiles($files) {
		$this->files = $files;
	}

	/**
	 * @param string $nuke
	 */
	public function setNuke($nuke) {
		$this->nuke = $nuke;
	}
}

/**
 * This is an search helper. It assists the creation of queries that will be used to find an given release.
 * @author <a href="http://www.rogiel.com/">Rogiel</a>
 * @since 1.0
 */
interface Pre_SearchHelper {
	function getSearchQuery();
}

/**
 * This Pre_SearchHelper asists searching for TVShow releases
 * @author <a href="http://www.rogiel.com/">Rogiel</a>
 * @since 1.0
 */
class Pre_TVShow_SearchHelper implements Pre_SearchHelper {
	private $name;
	private $season = null;
	private $episode = null;

	public function __construct($name, $season = null, $episode = null) {
		$this->name = $name;
		$this->season = $season;
		$this->episode = $episode;
	}

	public function getSearchQuery() {
		$query = $this->name;
		if ($this->season != null) {
			$query .= " S" . predb_padding_zero($this->season);
			if ($this->episode != null)
			$query .= "E" . predb_padding_zero($this->episode);
		}
		return str_replace(" ", ".", $query);
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return Pre_TVShow_SearchHelper this instance
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return the $season
	 */
	public function getSeason() {
		return $this->season;
	}

	/**
	 * @param int $season
	 * @return Pre_TVShow_SearchHelper this instance
	 */
	public function setSeason($season) {
		$this->season = $season;
		return $this;
	}

	/**
	 * @return the $episode
	 */
	public function getEpisode() {
		return $this->episode;
	}

	/**
	 * @param int $episode
	 * @return Pre_TVShow_SearchHelper this instance
	 */
	public function setEpisode($episode) {
		$this->episode = $episode;
		return $this;
	}
}

/**
 * The pre adapter interface
 * @author <a href="http://www.rogiel.com/">Rogiel</a>
 * @since 1.0
 */
interface Pre_Adapter {
	/**
	 * Implements the underlying search method
	 * @param string $release
	 */
	function search($release);

	/**
	 * Implements the underlying latest method
	 */
	function latest();
}

/**
 * @param int $number
 * @return the number with padded zeros
 */
function predb_padding_zero($number) {
	if ($number < 10)
	return "0" . $number;
	return $number;
}
