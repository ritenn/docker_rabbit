<?php

namespace App\Services;


use App\Dictionary\EmailStatus;
use App\Interfaces\MailInterface;
use App\Models\Email;
use App\Notifications\SendEmailNotification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class MailService implements MailInterface
{
    public function __construct(private Email $model) {}

    /**
     * @param int $id
     *
     * @return Email|null
     */
    public function find(int $id) : ?Email
    {
        return $this->model->find($id);
    }

    /**
     * @param int $page
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public function listPaginate(int $page = 1, int $perPage = 15) : LengthAwarePaginator
    {
        Paginator::currentPageResolver(function() use ($page) {
            return $page;
        });

        return $this->model::paginate($perPage);
    }

    /**
     * @param array $data
     * @param bool $send
     *
     * @return Email
     */
    public function store(array $data, bool $send = true) : Email
    {
        $email = $this->model::create($data);

        if ($send)
        {
            $email->update(['status' => EmailStatus::SENDING]);
            $this->send($email);
        }

        return $email;
    }

    /**
     * @param Email $email
     *
     * @return bool
     */
    public function send(Email $email) : bool
    {
        try {
            $email->notify(new SendEmailNotification);
        } catch (\Exception $exception)
        {
            $email->update([
               'status' => EmailStatus::ERROR,
               'error_message' => $exception->getMessage()
            ]);

            return false;
        }

        return true;
    }

    /**
     * @param Email $email
     *
     * @return bool
     */
    public function delete(Email $email) : bool
    {
        return $email->delete();
    }
}
