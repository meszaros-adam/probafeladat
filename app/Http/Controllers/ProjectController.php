<?php

namespace App\Http\Controllers;

use App\Mail\ProjectEdited;
use App\Models\Contact;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{
    public function get(Request $request)
    {
        if ($request->filter == "null") {
            return Project::orderBy('id', 'desc')->withCount('contacts')->paginate(10);
        } else {
            return Project::where('status', $request->filter)->orderBy('id', 'desc')->withCount('contacts')->paginate(10);
        }
    }
    public function getSingle(Request $request)
    {
        return Project::where('id', $request->id)->with('contacts')->first();
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
                'user_id' => Auth::user()->id,
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

            return response($project->loadCount('contacts'), 201);
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

            $project = Project::find($request->id);

            $project->update([
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

            foreach ($contacts as $contact) {
                Mail::to($contact['email'])->send(new ProjectEdited($project, $project->getChanges()));
            }

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
