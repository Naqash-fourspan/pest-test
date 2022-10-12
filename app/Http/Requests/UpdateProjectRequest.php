<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateProjectRequest extends FormRequest
{

    public function authorize()
    {
        return Gate::allows('update', Project::where('uuid', $this->route('project_id'))->first());
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable|min:3'
        ];
    }
}
