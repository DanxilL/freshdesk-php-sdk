<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 20/04/2016
 * Time: 2:32 PM
 */

namespace Freshdesk;

use Freshdesk\Exceptions\AccessDeniedException;
use Freshdesk\Exceptions\ApiException;
use Freshdesk\Exceptions\ConflictingStateException;
use Freshdesk\Exceptions\MethodNotAllowedException;
use Freshdesk\Exceptions\NotFoundException;
use Freshdesk\Exceptions\RateLimitExceededException;
use Freshdesk\Exceptions\UnsupportedAcceptHeaderException;
use Freshdesk\Exceptions\UnsupportedContentTypeException;
use Freshdesk\Exceptions\ValidationException;

/**
 * Class TicketApi
 * @internal
 * @package Freshdesk
 */
class TicketApi
{
    const ENDPOINT = '/tickets';

    /**
     * @var Api
     */
    private $api;

    /**
     * CompanyApi constructor.
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     *
     * Create a ticket
     *
     * @param array|null $data
     * @return mixed|null
     * @throws ApiException
     * @throws ConflictingStateException
     * @throws RateLimitExceededException
     * @throws UnsupportedContentTypeException
     */
    public function create(array $data)
    {
        $this->api->request('POST', $this->endpoint(), $data);
    }

    /**
     *
     * Get a list of tickets
     *
     * @param array|null $query
     * @return mixed|null
     * @throws ApiException
     * @throws ConflictingStateException
     * @throws RateLimitExceededException
     * @throws UnsupportedContentTypeException
     */
    public function all(array $query = null)
    {
        $this->api->request('GET', $this->endpoint(), null, $query);
    }

    /**
     *
     * Get a ticket by id
     *
     * @param int $id
     * @param array|null $query
     * @return array|null
     * @throws AccessDeniedException
     * @throws ApiException
     * @throws ConflictingStateException
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @throws RateLimitExceededException
     * @throws UnsupportedAcceptHeaderException
     * @throws UnsupportedContentTypeException
     * @throws ValidationException
     */
    public function view($id, array $query = null)
    {
        $this->api->request('GET', $this->endpoint($id), null, $query);
    }

    /**
     * Update a ticket
     *
     * @param $id
     * @param array|null $data
     * @return mixed|null
     * @throws ApiException
     * @throws ConflictingStateException
     * @throws RateLimitExceededException
     * @throws UnsupportedContentTypeException
     */
    public function update($id, array $data = null)
    {
        $this->api->request('PUT', $this->endpoint($id), $data);
    }

    /**
     * Delete a ticket
     *
     * @param $id
     * @return mixed|null
     * @throws ApiException
     * @throws ConflictingStateException
     * @throws RateLimitExceededException
     * @throws UnsupportedContentTypeException
     */
    public function delete($id)
    {
        $this->api->request('DELETE', $this->endpoint($id));
    }

    /**
     * Restore a ticket
     *
     * @param $id
     * @return mixed|null
     * @throws ApiException
     * @throws ConflictingStateException
     * @throws RateLimitExceededException
     * @throws UnsupportedContentTypeException
     */
    public function restore($id)
    {
        $end = $id . '/restore';

        $this->api->request('PUT', $this->endpoint($end));
    }

    /**
     * List ticket fields
     *
     * @param array|null $query
     * @return mixed|null
     * @throws AccessDeniedException
     * @throws ApiException
     * @throws ConflictingStateException
     * @throws Exceptions\AuthenticationException
     * @throws NotFoundException
     */
    public function fields(array $query = null)
    {
        $this->api->request('GET', 'ticket_fields', null, $query);
    }

    /**
     * List conversations associated with a ticket
     *
     * @param array|null $query
     * @return mixed|null
     * @throws AccessDeniedException
     * @throws ApiException
     * @throws ConflictingStateException
     * @throws Exceptions\AuthenticationException
     * @throws NotFoundException
     */
    public function conversations($id, array $query = null)
    {
        $end = $id . '/conversations';

        $this->api->request('GET', $this->endpoint($end), null, $query);
    }

    /**
     * List time entries associated with a ticket
     *
     * @param array|null $query
     * @return mixed|null
     * @throws AccessDeniedException
     * @throws ApiException
     * @throws ConflictingStateException
     * @throws Exceptions\AuthenticationException
     * @throws NotFoundException
     */
    public function timeEntries($id, array $query = null)
    {
        $end = $id . '/time_entries';

        $this->api->request('GET', $this->endpoint($end), null, $query);
    }

    private function endpoint($id = null)
    {
        return $this->api->createEndpoint(self::ENDPOINT, $id);
    }

}