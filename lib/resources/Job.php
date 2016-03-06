<?php

namespace kop\kue\resources;

use kop\kue\Client;
use kop\kue\exceptions\ClientException;

/**
 * Class `Job`
 * ===========
 *
 * This class represents a `Job` resource of the Kue JSON API.
 *
 *
 * @link    https://kop.github.io/php-kue-client/ Project page.
 * @license https://github.com/kop/php-kue-client/blob/master/LICENSE.md MIT
 *
 * @author  Ivan Koptiev <ivan.koptiev@codex.systems>
 */
class Job
{
    /**
     * @var Client $_client Kue API client instance.
     */
    private $_client;

    /**
     * Class constructor.
     *
     * @param Client $client Kue API client instance.
     */
    public function __construct(Client $client)
    {
        $this->_client = $client;
    }

    /**
     * Search jobs.
     *
     * Jobs can be searched with a full text search (when search query is a string),
     * or with an extended search (when search query is an array).
     *
     * Full text search feature is turned off by default since Kue >=0.9.0.
     * Please {@link https://github.com/Automattic/kue#get-jobsearchq follow the Kue documentation} if you want to enable it.
     *
     * In case of extended search, the following array keys are recognized:
     *
     * - `from` _(required)_ - filters jobs with the specified ID range, starting with `from`;
     * - `to` _(required)_ - filters jobs with the specified ID range, ending with `to`;
     * - `state` - filters jobs by state, this field is required if `type` is also set;
     * - `type` - filters jobs by type;
     * - `order` - orders results by `asc` or `desc`.
     *
     * @param string|array $query Search query.
     *
     * @return bool|mixed API response or `false` if API request fails.
     * @throws \kop\kue\exceptions\ApiException If API request fails and {@link Client::$_throwExceptions} is enabled.
     * @throws \kop\kue\exceptions\ClientException If search request is composed wrong and {@link Client::$_throwExceptions} is enabled.
     *
     * @see https://github.com/Automattic/kue#get-jobsearchq
     * @see https://github.com/Automattic/kue#get-jobsfromtoorder
     * @see https://github.com/Automattic/kue#get-jobsstatefromtoorder
     * @see https://github.com/Automattic/kue#get-jobstypestatefromtoorder
     */
    public function search($query)
    {
        // Search by query string
        if (is_string($query)) {
            return $this->_client->request('GET', 'job/search', [
                'query' => [
                    'q' => $query,
                ]
            ]);
        }

        // Extended search
        if (is_array($query) && isset($query['from'], $query['to'])) {
            $requestPath = '';
            if (in_array('order', $query)) {
                $requestPath = "/{$query['order']}" . $requestPath;
            }
            $requestPath = "/{$query['from']}..{$query['to']}" . $requestPath;
            if (in_array('state', $query)) {
                $requestPath = "/{$query['state']}" . $requestPath;
            }
            if (in_array('type', $query)) {
                $requestPath = "/{$query['type']}" . $requestPath;
            }
            return $this->_client->request('GET', "jobs{$requestPath}");
        }

        $this->_client->getLogger()->error('Jobs search request is composed wrong!');
        if ($this->_client->getThrowExceptions()) {
            throw new ClientException('Jobs search request is composed wrong!');
        }

        return false;
    }

    /**
     * Creates a new job.
     *
     * @param string $type Job type.
     * @param array $data Job data.
     * @param array $options Kue job options (e.g. attempts, priority, etc).
     *
     * @return bool|mixed API response or `false` if API request fails.
     * @throws \kop\kue\exceptions\ApiException If API request fails and {@link Client::$_throwExceptions} is enabled.
     *
     * @see https://github.com/Automattic/kue#post-job
     */
    public function create($type, $data, $options = [])
    {
        return $this->_client->request('POST', 'job', [
            'json' => [
                'type' => $type,
                'data' => $data,
                'options' => $options,
            ]
        ]);
    }

    /**
     * Returns a job by it's ID.
     *
     * @param integer $id Job ID.
     *
     * @return bool|mixed API response or `false` if API request fails.
     * @throws \kop\kue\exceptions\ApiException If API request fails and {@link Client::$_throwExceptions} is enabled.
     *
     * @see https://github.com/Automattic/kue#get-jobid
     */
    public function get($id)
    {
        return $this->_client->request('GET', "job/{$id}");
    }

    /**
     * Returns job logs by job ID.
     *
     * @param integer $id Job ID.
     *
     * @return bool|mixed API response or `false` if API request fails.
     * @throws \kop\kue\exceptions\ApiException If API request fails and {@link Client::$_throwExceptions} is enabled.
     *
     * @see https://github.com/Automattic/kue#get-jobidlog
     */
    public function logs($id)
    {
        return $this->_client->request('GET', "job/{$id}/log");
    }

    /**
     * Deletes a job by it's ID.
     *
     * @param integer $id Job ID.
     *
     * @return bool|mixed API response or `false` if API request fails.
     * @throws \kop\kue\exceptions\ApiException If API request fails and {@link Client::$_throwExceptions} is enabled.
     *
     * @see https://github.com/Automattic/kue#delete-jobid
     */
    public function delete($id)
    {
        return $this->_client->request('DELETE', "job/{$id}");
    }
}