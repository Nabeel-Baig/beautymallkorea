<?php

namespace App\Services;

use App\Enums\PermissionEnum;
use App\Http\Requests\Tag\CreateTagRequest;
use App\Http\Requests\Tag\DeleteManyTagsRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Models\Tag;
use App\Services\Datatables\DataTableService;
use Illuminate\Http\JsonResponse;

class TagService {
	public function __construct(private readonly DataTableService $datatable) {}

	final public function paginate(): JsonResponse {
		$model = Tag::class;
		$routeModelName = "tags";
		$columns = ["id", "name"];

		return $this->datatable->of($model)
			->withColumns($columns)
			->withSelectionColumn()
			->withViewAction(PermissionEnum::TAG_SHOW)
			->withEditAction(PermissionEnum::TAG_EDIT)
			->withDeleteAction(PermissionEnum::TAG_DELETE)
			->paginate($routeModelName);
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
