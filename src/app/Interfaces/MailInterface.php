<?php

namespace App\Interfaces;


use App\Models\Email;
use Illuminate\Pagination\LengthAwarePaginator;

interface MailInterface
{
    /**
     * @param int $id
     *
     * @return Email|null
     */
    public function find(int $id) : ?Email;


    /**
     * @param int $page
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public function listPaginate(int $page = 1, int $perPage = 15) : LengthAwarePaginator;

    /**
     * @param array $data
     * @param bool $send
     *
     * @return Email
     */
    public function store(array $data, bool $send = true) : Email;

    /**
     * @param Email $email
     *
     * @return bool
     */
    public function send(Email $email) : bool;

    /**
     * @param Email $email
     *
     * @return bool
     */
    public function delete(Email $email) : bool;
}
