<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\CreateTagRequest;
use App\Http\Requests\Tag\DeleteManyTagsRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TagController extends Controller {
	private readonly string $title;

	public function __construct(private readonly TagService $tagService) {
		$this->title = "Tags";
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function index(): View {
		$this->authorize("access", [Tag::class, PermissionEnum::TAG_ACCESS]);
		$content['title'] = $this->title;
		$content['headers'] = ["ID", "Tag Name"];
		return view("admin.tags.index")->with($content);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function paginate(): JsonResponse {
		$this->authorize("access", [Tag::class, PermissionEnum::TAG_ACCESS]);
		return $this->tagService->paginate();
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function store(CreateTagRequest $createTagRequest): RedirectResponse {
		$this->authorize("access", [Tag::class, PermissionEnum::TAG_CREATE]);

		$this->tagService->create($createTagRequest);

		return redirect()->route("admin.tags.index")->withCreatedSuccessToastr("Tag");
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function create(): View {
		$this->authorize("access", [Tag::class, PermissionEnum::TAG_CREATE]);
		$content['title'] = $this->title;
		return view("admin.tags.create")->with($content);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function edit(Tag $tag): View {
		$this->authorize("access", [Tag::class, PermissionEnum::TAG_EDIT]);

		$content['model'] = $tag;
		$content['title'] = $this->title;

		return view("admin.tags.edit")->with($content);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function update(Tag $tag, UpdateTagRequest $updateTagRequest): RedirectResponse {
		$this->authorize("access", [Tag::class, PermissionEnum::TAG_EDIT]);

		$this->tagService->update($tag, $updateTagRequest);

		return redirect()->route("admin.tags.index")->withUpdatedSuccessToastr("Tag");
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function deleteMany(DeleteManyTagsRequest $deleteManyTagsRequest): JsonResponse {
		$this->authorize("access", [Tag::class, PermissionEnum::TAG_DELETE]);

		$this->tagService->deleteMany($deleteManyTagsRequest);
		$content["message"] = "Tags deleted successfully";

		return response()->json($content);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function delete(Tag $tag): JsonResponse {
		$this->authorize("access", [Tag::class, PermissionEnum::TAG_DELETE]);

		$this->tagService->delete($tag);
		$content["message"] = "Tag deleted successfully";

		return response()->json($content);
	}
}
