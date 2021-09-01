<?php

namespace App\Http\Controllers\Sponsor;

use App\Models\Sponsor;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\SponsorResource;
use App\Http\Resources\SponsorCollection;

class SponsorApiController extends Controller
{
    use ApiResponse;
     /**
      * @return json {list of sponsors}
      */
    public function index(Request $request)
    {
        $searchVal = $request->input('query.generalSearch', null);
        if ($searchVal) {
          $likeVal = '%'.$searchVal.'%';
          $total = Sponsor::orWhere('name', 'like', $likeVal)->count();
                        //->orWhere('code', 'like', $likeVal)
                        //->orWhere('address', 'like', $likeVal)->count();
          $meta = $this->getMetaData($request, $total, 'name');
          $sponsors = Sponsor::where('name', 'like', $likeVal)
                        ->offset($meta['offset'])->limit($meta['perpage'])
                        ->orderBy($meta['field'], $meta['sort'])->get();
        } else {
          $total = Sponsor::count();
          $meta = $this->getMetaData($request, $total, 'name');
          // select * from sponsors where offset 30 limit 10;
          $sponsors = Sponsor::offset($meta['offset'])->limit($meta['perpage'])
                      ->orderBy($meta['field'], $meta['sort'])->get();
        }
        // pagination:
        $resColl = new SponsorCollection($sponsors);
        $resData = $resColl->toArray($request);
        $resData['meta'] = $meta;
        return $this->api_success($resData);
    }
    public function create(Request $request)
    {
        $msg = '';
        $request->validate([
          'name' => 'required|string|max:255',
          'code' => 'nullable|string|max:64',
          'address' => 'nullable|string',
        ]);
        $id = $request->input('id', 0);
        if ($id) {
          $sponsor = Sponsor::where('id', '=', $id)->first();
          $msg = 'Updated sponsor';
        } else { // create
          $sponsor = new Sponsor();
          $msg = 'Added sponsor';
        }
        $sponsor->name = $request->input('name');
        $sponsor->code = $request->input('code');
        $sponsor->address = $request->input('address');
        $sponsor->save();
        return $this->success($msg);
    }
    public function delete(Request $request)
    {
        $id = $request->input('id');
        if ($id) {
          Sponsor::destroy($id);
        }
        return $this->success('Deleted sponsor');
    }
}
