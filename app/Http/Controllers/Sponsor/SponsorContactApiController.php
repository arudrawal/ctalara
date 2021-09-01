<?php

namespace App\Http\Controllers\Sponsor;

use App\Models\Sponsor;
use App\Models\SponsorContact;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Resources\SponsorContactResource;
use App\Http\Resources\SponsorContactCollection;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class SponsorContactApiController extends Controller
{
    use ApiResponse;
     /**
      * @return json {list of sponsor contact}
      */
    public function index(Request $request, $sponsor_id)
    {
        $contacts = collect([]); // empty
        $sponsor = Sponsor::where('id', '=', $sponsor_id)->first();
        if ($sponsor) {
            $spConts = SponsorContact::where('sponsor_id', $sponsor->id)->get();
            $total = $spConts->count();
            $meta = $this->getMetaData($request, $total, 'contact');
            // Apply offset and limit on collection
            if ($meta['sort'] == 'asc') {
              $contacts = $spConts->slice($meta['offset'], $meta['perpage'])->sortBy($meta['field']);
            } else {
              $contacts = $spConts->slice($meta['offset'], $meta['perpage'])->sortByDesc($meta['field']);
            }
        }
        $resCont = new SponsorContactCollection($contacts);
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
