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
namespace PreDB;

use DateTime;

/**
 * Pre entry
 *
 * @author @author <a href="http://www.rogiel.com/">Rogiel</a>
 * @since 1.0
 */
class Release {
	/**
	 *
	 * @var string
	 */
	var $release;
	
	/**
	 *
	 * @var string
	 */
	var $type;
	
	/**
	 *
	 * @var DateTime
	 */
	var $date;
	
	/**
	 *
	 * @var int
	 */
	var $size;
	
	/**
	 *
	 * @var int
	 */
	var $files;
	
	/**
	 *
	 * @var string
	 */
	var $nuke;

	/**
	 * Creates a new release instance.
	 *
	 * If $release is a string, it is set as the release name
	 * If $release is an arraym the following keys are set to the release object model: release, type, date, size, files and nuke.
	 *
	 * @param string $release
	 *        	the release argument
	 */
	public function __construct($release = NULL) {
		if (is_string($release)) {
			$this->release = $release;
		} else if (is_array($release)) {
			$this->release = (isset($release['release']) ? $release['release'] : NULL);
			$this->type = (isset($release['type']) ? $release['type'] : NULL);
			$this->date = (isset($release['date']) ? $release['date'] : NULL);
			$this->size = (isset($release['size']) ? $release['size'] : NULL);
			$this->files = (isset($release['files']) ? $release['files'] : NULL);
			$this->nuke = (isset($release['nuke']) ? $release['nuke'] : NULL);
		}
	}

	/**
	 *
	 * @return the string
	 */
	public function getRelease() {
		return $this->release;
	}

	/**
	 *
	 * @param string $release        	
	 */
	public function setRelease($release) {
		$this->release = $release;
	}

	/**
	 *
	 * @return the string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 *
	 * @param string $type        	
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 *
	 * @return the DateTime
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 *
	 * @param DateTime $date        	
	 */
	public function setDate(DateTime $date) {
		$this->date = $date;
	}

	/**
	 *
	 * @return the int
	 */
	public function getSize() {
		return $this->size;
	}

	/**
	 *
	 * @param int $size        	
	 */
	public function setSize($size) {
		$this->size = $size;
	}

	/**
	 *
	 * @return the int
	 */
	public function getFiles() {
		return $this->files;
	}

	/**
	 *
	 * @param int $files        	
	 */
	public function setFiles($files) {
		$this->files = $files;
	}

	/**
	 *
	 * @return the string
	 */
	public function getNuke() {
		return $this->nuke;
	}

	/**
	 *
	 * @return bool true if the released is nuked
	 */
	public function isNuked() {
		return $this->nuke != NULL;
	}

	/**
	 *
	 * @param string $nuke        	
	 */
	public function setNuke($nuke) {
		$this->nuke = $nuke;
	}
}