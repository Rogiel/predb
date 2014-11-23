# PreDB - Scene Releases Database API

PreDB is a PHP library that allows and makes easy to retrieve scene releases data from online services. Services are plugabble and can be implemented with only two methods!

## Examples
### Getting the latest releases

In this example we will be retrieving the latest releases that are available on the source.

```php
// configures the autoloader
require_once __DIR__ . '/PreDB/autoload.php';

// imports the PreDB class
use PreDB\PreDB;

// creates a new database instance
$db = new PreDB();

// queries the adapter for the latest releases
$result = $db->latest();
```

### Searching for a release

In this example we perform a search for a given release. You can search for any query and the adapter will try to locate it on the remote service.

**Important**: Setup steps were ommited!

```php
// queries the adapter for the latest releases
$result = $db->search('Microsoft Office');
```

### Get an specific release by name
In case you already know the release name, but want to retrieve more data about a given release, you can get an specific release like this:

**Important**: Setup steps were ommited!

```php
// queries the adapter for the latest releases
$result = $db->get('My.Awesome.Release-AWESOME'); // is an instanceo of \PreDB\Release
```

### Using search helpers
Search helper can be useful when you want to search standardized data, like TV shows. Currently, only the TVShow search helper is available, but more could be created very easily.

**Important**: Setup steps were ommited!

```php
use PreDB\Search\TVShow as TVShowHelper;

$result = $db->search(new TVShowHelper(
  "true blood", // the tv show name
  4, // the season
  1 // the episode
));
```

Since a single episode can have several releases, an array is returned.