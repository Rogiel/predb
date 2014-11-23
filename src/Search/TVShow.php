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
namespace PreDB\Search;

/**
 * This Helper asists searching for TVShow releases
 *
 * @author <a href="http://www.rogiel.com/">Rogiel</a>
 * @since 1.0
 */
class TVShow implements Helper {
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
			$query .= " S" . self::padZero($this->season);
			if ($this->episode != null)
				$query .= "E" . self::padZero($this->episode);
		}
		return str_replace(" ", ".", $query);
	}

	/**
	 *
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 *
	 * @param string $name
	 * @return TVShow this instance
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 *
	 * @return the $season
	 */
	public function getSeason() {
		return $this->season;
	}

	/**
	 *
	 * @param int $season
	 * @return TVShow this instance
	 */
	public function setSeason($season) {
		$this->season = $season;
		return $this;
	}

	/**
	 *
	 * @return the $episode
	 */
	public function getEpisode() {
		return $this->episode;
	}

	/**
	 *
	 * @param int $episode
	 * @return TVShow this instance
	 */
	public function setEpisode($episode) {
		$this->episode = $episode;
		return $this;
	}
	
	/**
	 *
	 * @param int $number
	 * @return the number with padded zeros
	 */
	private static function padZero($number) {
		if ($number < 10)
			return "0" . $number;
		return $number;
	}
}