PHP client for Kue JSON API
===========================

[Kue](https://github.com/Automattic/kue) is a priority job queue backed by redis, built for node.js.

This package is a PHP client for Kue JSON API.
It's tested with Kue version `0.10.3` and will be kept in sync with Kue changes on best effort basis.

[![Latest Stable Version](https://img.shields.io/packagist/v/kop/php-kue-client.svg)](https://packagist.org/packages/kop/php-kue-client)
[![Code Climate](https://img.shields.io/codeclimate/github/kop/php-kue-client.svg)](https://codeclimate.com/github/kop/php-kue-client/trends)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/kop/php-kue-client.svg)](https://scrutinizer-ci.com/g/kop/php-kue-client/)
[![Gemnasium](https://img.shields.io/gemnasium/kop/php-kue-client.svg)](https://gemnasium.com/kop/php-kue-client)
[![License](https://img.shields.io/packagist/l/kop/php-kue-client.svg)](https://packagist.org/packages/kop/php-kue-client)


Requirements
------------

- PHP 5.5


Installation
------------

The preferred way to install this extension is through [Composer](http://getcomposer.org/).

Either run

```
composer require kop/php-kue-client "dev-master"
```

or add

```
"kop/php-kue-client": "dev-master"
```

to the `require` section of your `composer.json` file.


Usage
-----

In order to connect to the Kue JSON API, all you need to do is to create an instance of `\kop\kue\Client`:

```php
$client = new \kop\kue\Client('https://kue-dashboard.domain.com');

// Get Kue stats
$stats = $client->stats();

// Create a new Job
$response = $client->jobs()->create(
    'email',
    [
        'title' => 'welcome email for tj',
        'to' => 'tj@learnboost.com',
        'template' => 'welcome-email',
    ],
    [
        'priority' => 'high',
    ],
);
$jobID = $response['id'];

// Get Job by it's ID
$job = $client->jobs()->get($jobID);

// Delete Job by it's ID
$client->jobs()->delete($jobID);
```


Supported API endpoints
-----------------------

This API client supports all endpoints exposed by Kue JSON API.
The followings are methods that are used to map to this API endpoints:

### General

This methods 

- `stats()` - Responds with state counts, and worker activity time in milliseconds;
- `jobs()` - Returns commands that are related to Kue jobs.

### Jobs

This methods can be accessed via `jobs()` method of the `\kop\kue\Client`.

- `search($query)` - Search jobs;
- `create($type, $data, $options = [])` - Creates a new job;
- `get($id)` - Returns a job by it's ID;
- `logs($id)` - Returns job logs by job ID;
- `delete($id)` - Deletes a job by it's ID.


Configuration
-------------

This API client implements some additional features that are related to logging and errors handling.
Please see the class source code for more details - it's well documented and should not cause any questions.


Report
------

- Report any issues on the [GitHub Issue Tracker](https://github.com/kop/php-kue-client/issues).


License
-------

This project is released under the MIT License.
See the bundled [LICENSE.md](https://github.com/kop/php-kue-client/blob/master/LICENSE.md) for details.


Resources
---------

- [Project Page](https://kop.github.io/php-kue-client)
- [Packagist Package](https://packagist.org/packages/kop/php-kue-client)
- [Source Code](https://github.com/kop/php-kue-client)