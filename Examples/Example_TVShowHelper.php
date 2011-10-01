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

// This example used the Pre_TVShow_SearchHelper to search an given
// episode of an TVShow. It can be used to filter data returned.

require_once '../PreDatabase_Library.php';

$db = new Pre_DB();

// Show: True Blood
// Season: 4
// Episode 1
print_r($db->search(new Pre_TVShow_SearchHelper(
	"true blood", // the tv show name
	4, // the season
	1 // the episode
)));

?>