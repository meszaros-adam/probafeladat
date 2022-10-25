<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{

    public function get(Request $request)
    {
        if ($request->filter == "null"){
            return Project::orderBy('id', 'desc')->withCount('contacts')->paginate(10);
        }else{
            return Project::where('status', $request->filter)->orderBy('id', 'desc')->withCount('contacts')->paginate(10);
        }
            
    }
    public function add(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $project = Project::create([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            $contacts = [];

            foreach ($request->contacts as $contact) {
                array_push($contacts, [
                    'name' => $contact['name'],
                    'email' => $contact['email'],
                    'project_id' => $project['id'],
                ]);
            }

            Contact::insert($contacts);

            DB::commit();

            return response($project, 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return response($th, 500);
        }
    }
    public function edit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $project = Project::where('id', $request->id)->update([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            Contact::where('project_id', $request->id)->delete();

            $contacts = [];

            foreach ($request->contacts as $contact) {
                array_push($contacts, [
                    'name' => $contact['name'],
                    'email' => $contact['email'],
                    'project_id' => $request->id,
                ]);
            }

            Contact::insert($contacts);

            DB::commit();

            return response($project, 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return response($th, 500);
        }
    }
    public function delete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        Project::where('id', $request->id)->delete();
    }
}
