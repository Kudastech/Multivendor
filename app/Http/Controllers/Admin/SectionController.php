<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionController extends Controller
{
    public function sections()
    {
        $sections = Section::get()->toArray();

        // dd($sections);

        return view('admin.sections.sections')->with(compact('sections'));
    }

    public function updateSectionStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
             $status = $data['status'] == "Active" ? 0 : 1 ;

            Section::where('id',$data['section_id'])->update(['status'=>$status]);

            return response()->json(['status'=> $status, 'section_id'=>$data['section_id']]);
        }
    }
}
