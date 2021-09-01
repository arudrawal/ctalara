<?php

namespace App\Http\Controllers\Protocol;

use App\Models\Sponsor;
use App\Models\SponsorContact;
use App\Http\Resources\SponsorContactResource;
use App\Http\Resources\SponsorContactCollection;

use App\Models\Protool;
use App\Models\ProtocolVisit;
use App\Http\Resources\ProtocolVisitResource;
use App\Http\Resources\ProtocolVisitCollection;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class ProtocolVisitApiController extends Controller
{
    use ApiResponse;
     /**
      * @return json {list of protocol visits}
      */
    public function index(Request $request, $protocol_id)
    {
        $visitsAll = ProtocolVisit::where('protocol_id', $protocol_id)->orderBy('order', 'asc')->get();
        $total = $visitsAll->count();
        $meta = $this->getMetaData($request, $total, 'order');
        // Apply offset and limit on collection
        if ($meta['sort'] == 'asc') {
          $visits = $visitsAll->slice($meta['offset'], $meta['perpage'])->sortBy($meta['field']);
        } else {
          $visits = $visitsAll->slice($meta['offset'], $meta['perpage'])->sortByDesc($meta['field']);
        }
        $resCont = new ProtocolVisitCollection($visits);
        $resData = $resCont->toArray($request);
        $resData['meta'] = $meta;
        return $this->api_success($resData);
    }
    
    public function create(Request $request)
    {
        $msg = '';
        $validator = $request->validate([
          'sponsor_id' => 'required|numeric',
          'name' => 'required|string|max:255',
          'address' => 'nullable|string',
          'email' => 'nullable|email',
          'phone' => 'nullable|numeric',
          'fax' => 'nullable|numeric',
        ]);
        $id = $request->input('id', 0);
        if ($id) {
          $contact = SponsorContact::where('id', $id)->first();
          $msg = 'Updated contact';
        } else { // create
          $contact = new SponsorContact();
          $msg = 'Added contact';
        }
        $contact->sponsor_id = $request->input('sponsor_id');
        $contact->name = $request->input('name');
        $contact->address = $request->input('address');
        $contact->phone = $request->input('phone');
        $contact->email = $request->input('email');
        $contact->fax = $request->input('fax');
        $contact->save();
        return $this->success($msg);
    }
    public function delete(Request $request)
    {
        $id = $request->input('id');
        if ($id) {
          SponsorContact::destroy($id);
        }
        return $this->success('Deleted contact');
    }
}
