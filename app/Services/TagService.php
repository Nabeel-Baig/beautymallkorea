<?php

namespace App\Services;

use App\Http\Requests\Tag\CreateTagRequest;
use App\Http\Requests\Tag\DeleteManyTagsRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;

class TagService {
	final public function paginate(): JsonResponse {
		/*$model = Tag::class;
		$routeModelName = "tags";
		$columns = ["id", "name"];

		return $this->datatable->of($model)
			->withColumns($columns)
			->withSelectionColumn()
			->withViewAction(PermissionEnum::TAG_SHOW)
			->withEditAction(PermissionEnum::TAG_EDIT)
			->withDeleteAction(PermissionEnum::TAG_DELETE)
			->paginate($routeModelName);*/
		return datatables()->of(Tag::orderBy('id', 'desc')->get())
			->addColumn('selection', function ($data) {
				return '<input type="checkbox" class="delete_checkbox flat" value="' . $data['id'] . '">';
			})->addColumn('actions', function ($data) {
				$edit = '';
				$view = '';
				$delete = '';
				if (Gate::allows('tag_edit')) {
					$edit = '<a title="Edit" href="' . route('admin.tags.edit', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>&nbsp;';
				}
				if (Gate::allows('tag_show')) {
					$view = '<button title="View" type="button" name="view" id="' . $data['id'] . '" class="view btn btn-info btn-sm"><i class="fa fa-eye"></i></button>&nbsp;';
				}
				if (Gate::allows('tag_delete')) {
					$delete = '<button title="Delete" type="button" name="delete" id="' . $data['id'] . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
				}
				return $edit . $view . $delete;
			})->rawColumns(['selection', 'actions'])->make(true);
	}

	final public function getTagsForDropdown(): Collection {
		return Tag::select(["id", "name"])->get();
	}

	final public function create(CreateTagRequest $createTagRequest): Tag {
		$data = $createTagRequest->validated();

		return Tag::create($data);
	}

	final public function update(Tag $tag, UpdateTagRequest $updateTagRequest): Tag {
		$data = $updateTagRequest->validated();

		$tag->update($data);

		return $tag;
	}

	final public function deleteMany(DeleteManyTagsRequest $deleteManyTagsRequest): void {
		$validatedTagIds = $deleteManyTagsRequest->validated();

		Tag::whereIn("id", $validatedTagIds["ids"])->delete();
	}

	final public function delete(Tag $tag): void {
		$tag->delete();
	}
}
