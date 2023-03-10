<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\MassDestroyCategoryRequest;
use App\Http\Requests\Admin\Categories\StoreCategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends Controller {
	public function __construct() {
		$this->title = ucwords(str_replace('-', ' ', request()->segment(2)));
	}

	public function index(Request $request) {
		abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		if (\request()->ajax()) {
			$categories = Category::orderBy('id', 'desc');
			if (\request()->get('id') && \request()->isMethod('get')) {
				$categories = $categories->where('category_id', request()->get('id'))->get();
			} else {
				$categories = $categories->whereNull('category_id')->get();
			}
			return datatables()->of($categories)
				->addColumn('checkbox', function ($data) {
					return '<input type="checkbox" class="delete_checkbox flat" value="' . $data['id'] . '">';
				})->addColumn('sub_categories', function ($data) {
					$count = Category::where('category_id', $data->id)->count();
					return '<a href="' . route('admin.categories.index', ['id' => $data->id]) . '">' . $count . '</a>';
				})->addColumn('action', function ($data) {
					$edit = '';
					$view = '';
					$delete = '';
					if (Gate::allows('category_edit')) {
						$edit = '<a title="Edit" href="' . route('admin.categories.edit', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>&nbsp;';
					}
					if (Gate::allows('category_show')) {
						$view = '<button title="View" type="button" name="view" id="' . $data['id'] . '" class="view btn btn-info btn-sm"><i class="fa fa-eye"></i></button>&nbsp;';
					}
					if (Gate::allows('category_delete')) {
						$delete = '<button title="Delete" type="button" name="delete" id="' . $data['id'] . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
					}
					return $edit . $view . $delete;
				})->rawColumns(['checkbox', 'action', 'sub_categories'])->make(true);
		}
		$content['title'] = $this->title;
		return view('admin.' . request()->segment(2) . '.list')->with($content);
	}

	final public function create(): View {
		abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		$categories = Category::latest()->get()->pluck('name', 'id');
		$title = $this->title;
		return view('admin.' . request()->segment(2) . '.form', compact('title', 'categories'));
	}

	final public function store(StoreCategoryRequest $request): RedirectResponse {
		Category::create(handleFiles(\request()->segment(2), array_merge($request->validated(), ['slug' => Str::slug($request->name, '-')])));
		return redirect()->route('admin.' . request()->segment(2) . '.index')->withToastSuccess('Category Created Successfully!');
	}

	final public function show(Category $category): JsonResponse {
		return \response()->json($category);
	}

	final public function edit(Category $category): View {
		abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		$categories = Category::latest()->get()->pluck('name', 'id');
		$title = $this->title;
		return view('admin.' . request()->segment(2) . '.form', compact('title', 'category', 'categories'));
	}

	final public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse {
		$category->update(handleFilesIfPresent(\request()->segment(2), $request->validated(), $category));
		return redirect()->route('admin.categories.index')->withToastSuccess('Category Updated Successfully!');
	}

	final public function destroy(Category $category): JsonResponse {
		abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		$category->delete();
		return \response()->json('Category Deleted Successfully!');
	}

	final public function massDestroy(MassDestroyCategoryRequest $request): JsonResponse {
		Category::whereIn('id', request('ids'))->delete();
		return \response()->json('Selected records Deleted Successfully.');
	}
}
