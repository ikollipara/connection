<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LikeLogController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $model_id = $request->input('model_id');
        $model_type = $request->input('model_type');

        try {
            $model = $model_type::findOrFail($model_id);

            $model->like();

            info('LikeLogController', [
                'model_id' => $model_id,
                'model_type' => $model_type,
                'likes' => $model->likes(),
            ]);

            return response(
                content: [
                    'likes' => $model->likes(),
                ],
                status: Response::HTTP_OK
            );

        } catch (\Throwable $th) {
            $message = $th->getMessage();
            logger()->error($message, ['request' => $request->all()]);

            return response(
                content: [
                    'message' => 'Something went wrong',
                ],
                status: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}