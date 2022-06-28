<?php

namespace App\Http\Controllers\Api\Email;


use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\Email\IndexRequest;
use App\Interfaces\MailInterface;
use Illuminate\Http\JsonResponse;

class EmailController extends Controller
{
    /**
     * @param MailInterface $mailService
     */
    public function __construct(private readonly MailInterface $mailService) {}

    /**
     * @param IndexRequest $request
     *
     * @return JsonResponse
     */
    public function index(IndexRequest $request) : JsonResponse
    {
        return $this->responseSuccess(
            $this->mailService->listPaginate(
                $request->get('page', 1),
                $request->get('perPage', 15),
            )->toArray()
        );
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id) : JsonResponse
    {
        $email = $this->mailService->find($id);

        if (is_null($email))
        {
            return $this->responseFailed(status: 404, message: 'Email not found.');
        }

        return $this->responseSuccess($email->toArray());
    }

    /**
     * @param StoreRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreRequest $request) : JsonResponse
    {
        return $this->responseSuccess(
            data: $this->mailService->store($request->validated()),
            status: 201
        );
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id) : JsonResponse
    {
        $email = $this->mailService->find($id);

        if (is_null($email))
        {
            return $this->responseFailed(status: 404, message: 'Email not found.');
        }

        $this->mailService->delete($email);

        return $this->responseSuccess(message: 'Email deleted.');
    }
}
