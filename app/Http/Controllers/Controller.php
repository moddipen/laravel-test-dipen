<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Crypt;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $id
     * @return mixed
     */
    public function encrypt($id)
    {
        $encryptId = Crypt::encrypt($id);
        return $encryptId;
    }

    /**
     * @param $id
     * @return mixed|void
     */
    public function decrypt($id)
    {
        try{
            $decryptId = Crypt::decrypt($id);
            return $decryptId;
        }
        catch(DecryptException $e){
            return abort(404);
        }
    }
}
