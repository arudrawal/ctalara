<?php

namespace App\Http\Controllers\Study;

use App\Models\Study;
use App\Models\Sponsor;
use App\Models\Protocol;
use App\Http\Resources\StudyResource;
use App\Http\Resources\StudyCollection;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudyApiController extends Controller
{
    use ApiResponse;
     /**
      * @return json {list of studies}
      */
    public function index(Request $request, $sponsor_id)
    {
        $studiesAll = DB::table('studies')
          ->join('protocols', 'protocols.id', '=', 'studies.protocol_id')
          ->select('studies.*', 'protocols.code as protocol_code', 'protocols.sponsor_id')
          ->where('protocols.sponsor_id', '=', $sponsor_id)->get();
        $total = $studiesAll->count();
        $meta = $this->getMetaData($request, $total, 'id');
        // Apply offset and limit on collection
        if ($meta['sort'] == 'asc') {
          $studies = $studiesAll->slice($meta['offset'], $meta['perpage'])->sortBy($meta['field']);
        } else {
          $studies = $studiesAll->slice($meta['offset'], $meta['perpage'])->sortByDesc($meta['field']);
        }
        // pagination:
        $resColl = new StudyCollection($studies);
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
