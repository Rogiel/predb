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

use PreDB\Adapter\Adapter;
use PreDB\Search\Helper as SearchHelper;

class PreDB {
	/**
	 * The Pre_Adapter implementation
	 *
	 * @var Adapter
	 */
	private $adapter;

	/**
	 * Creates a new instance
	 *
	 * @param Adapter $adapter
	 *        	the adapter to use. If none is provided an default is used.
	 */
	public function __construct(Adapter $adapter = null) {
		if ($adapter == null) {
			$adapter = new \PreDB\Adapter\OrlyDB();
		}
		$this->adapter = $adapter;
	}

	/**
	 * Searches the pre database for certain releases
	 *
	 * @param string|SearchHelper $query
	 *        	the query
	 * @param int $page
	 *        	the page to return
	 */
	public function search($query, $page = 1) {
		if ($query instanceof SearchHelper) {
			$query = $query->getSearchQuery();
		}
		return $this->adapter->search($query, $page);
	}

	/**
	 * Searches the pre database for an certain release
	 *
	 * @param string $release
	 *        	the release name
	 * @return Pre_Release
	 */
	public function get($release) {
		$releases = $this->adapter->search($release);
		return predb_find_suitable_release($release, $releases);
	}

	/**
	 * Retrieve the latest pre entries from the database
	 *
	 * @param int $page
	 *        	the page to load
	 */
	public function latest($page = 1) {
		return $this->adapter->latest($page);
	}
}