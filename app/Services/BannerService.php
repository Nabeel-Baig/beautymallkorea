<?php

namespace App\Services;

use App\Enums\PermissionEnum;
use App\Http\Requests\Admin\Banner\ManageBannerRequest;
use App\Http\Requests\Admin\Banner\MassDestroyBannerRequest;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;

class BannerService {
	public function __construct() {}

	final public function paginate(): JsonResponse {
		return datatables()->of(Banner::orderBy('id', 'desc')->get())
			->addColumn('selection', function ($data) {
				return '<input type="checkbox" class="delete_checkbox flat" value="' . $data['id'] . '">';
			})->addColumn('image', function ($data) {
				return '<img width="65" src="' . asset($data->image) . '">';
			})->addColumn('actions', function ($data) {
				$edit = '';
				$delete = '';
				if (Gate::allows(PermissionEnum::BANNER_EDIT->value)) {
					$edit = '<a title="Edit" href="' . route('admin.banners.edit', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>&nbsp;';
				}
				if (Gate::allows(PermissionEnum::BANNER_DELETE->value)) {
					$delete = '<button title="Delete" type="button" name="delete" id="' . $data['id'] . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
				}
				return $edit . $delete;
			})->rawColumns(['selection', 'actions', 'image'])->make(true);
	}

	final public function create(ManageBannerRequest $manageBannerRequest): Banner {
		return Banner::create(handleFiles('banners', $manageBannerRequest->validated()));
	}

	final public function update(ManageBannerRequest $request, Banner $banner): Banner {
		$data = handleFilesIfPresent('banners', $request->validated(), $banner);
		$banner->update($data);
		return $banner;
	}

	final public function deleteMany(MassDestroyBannerRequest $massDestroyBannerRequest): void {
		$recordsToDelete = $massDestroyBannerRequest->get("ids");

		Banner::whereIn("id", $recordsToDelete)->delete();
	}

	final public function delete(Banner $banner): void {
		$banner->delete();
	}

}
