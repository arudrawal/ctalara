<?php

namespace App\Http\Controllers\Protocol;

use App\Models\Sponsor;
use App\Models\Protocol;
use App\Http\Resources\ProtocolResource;
use App\Http\Resources\ProtocolCollection;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProtocolApiController extends Controller
{
    use ApiResponse;
     /**
      * @return json {list of protocols}
      */
    public function index(Request $request, $sponsor_id)
    {
        $protocols = null;
        if ($sponsor_id) {
          $total = Protocol::where('sponsor_id', $sponsor_id)->count();
          $meta = $this->getMetaData($request, $total, 'code');
          // select * from protocols where offset 30 limit 10;
          $protocols = Protocol::where('sponsor_id', $sponsor_id)->offset($meta['offset'])->limit($meta['perpage'])
                      ->orderBy($meta['field'], $meta['sort'])->get();
        }
        // pagination:
        $resColl = new ProtocolCollection($protocols);
        $resData = $resColl->toArray($request);
        $resData['meta'] = $meta;
        return $this->api_success($resData);
    }
    public function create(Request $request)
    {
        $msg = '';
        $request->validate([
          'code' => 'nullable|string|max:64',
          'rev' => 'nullable|string|max:255',
          'address' => 'nullable|string',
        ]);
        $sponsor_id = $request->input('sponsor_id', 0);
        if ($sponsor_id) {
          $sponsor = Sponsor::where('id', '=', $sponsor_id)->first();
        } else { // error sponsor_id required
          return $this->error('Valid sponsor is required', 400);
        }
        $id = $request->input('id', 0);
        if ($id) {
          $protocol = Protocol::where('id', '=', $id)->first();
          $msg = 'Updated protocol';
        } else { // create
          $protocol = new Protocol();
          $msg = 'Added protocol';
        }
        $protocol->sponsor_id = $sponsor_id;
        $protocol->code = $request->input('code');
        $protocol->rev = $request->input('rev');
        $protocol->description = $request->input('description');
        $protocol->phase = $request->input('phase');
        $protocol->product = $request->input('product');
        $protocol->drafted_at = $request->input('drafted_at');
        
        $protocol->save();
        return $this->success($msg);
    }
    public function delete(Request $request)
    {
        $id = $request->input('id');
        if ($id) {
          Protocol::destroy($id);
        }
        return $this->success('Deleted protocol');
    }
}
