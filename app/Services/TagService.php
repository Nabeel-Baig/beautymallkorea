<?php

namespace App\Services;

use App\Enums\PermissionEnum;
use App\Http\Requests\Admin\Tag\CreateTagRequest;
use App\Http\Requests\Admin\Tag\DeleteManyTagsRequest;
use App\Http\Requests\Admin\Tag\UpdateTagRequest;
use App\Models\Tag;
use App\Services\Datatables\DataTableService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class TagService {
	public function __construct(private readonly DataTableService $dataTableService) {}

	final public function paginate(): JsonResponse {
		$model = Tag::class;
		$routeModelName = "tags";
		$columns = ["id", "name"];

		return $this->dataTableService->of($model)
			->withColumns($columns)
			->withSelectionColumn()
			->withEditAction(PermissionEnum::TAG_EDIT)
			->withDeleteAction(PermissionEnum::TAG_DELETE)
			->paginate($routeModelName);
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
