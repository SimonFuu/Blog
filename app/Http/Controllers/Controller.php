<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $request -> _url = null;
        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }

    protected function getSearchConditions(Request $request)
    {
        $default = [];
        $pagination = [];
        $req = $request -> except(['_token', '_url']);
        foreach ($req as $key => $value) {
            if (!is_null($value)) {
                $default[$key] = $value;
                $pagination[$key] = $value;
            }
        }
        return ['default' => $default, 'pagination' => $pagination];
    }
}
