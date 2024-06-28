<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\LineRequest;
use App\Models\Line;
use App\Services\Paginate;
use Illuminate\Http\Request;


class LineController extends Controller
{

    public function index()
    {
        $result = new Paginate(new Line(), 'lines', request('page'));
        return response()->success($result->get());
    }

    public function store(LineRequest $request)
    {
        Line::create($request->validated());
        return response()->success('', 'تم الانشاء بنجاح');
    }

    public function update(LineRequest $request, $line_id)
    {
        $line = Line::findOrFail($line_id);
        $line->update($request->validated());
        return response()->success('', 'تم التعديل بنجاح');
    }

    public function line_select()
    {
        return response()->success(Line::all(['id','name']));
    }
}
