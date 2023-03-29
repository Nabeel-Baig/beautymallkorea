<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banner\ManageBannerRequest;
use App\Http\Requests\Admin\Banner\MassDestroyBannerRequest;
use App\Models\Banner;
use App\Services\BannerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class BannersController extends Controller
{
	public function __construct(private readonly BannerService $bannerService) {
		$this->title = ucwords(str_replace('-', ' ', request()->segment(2)));
	}

	final public function index(): View
    {
		abort_if(Gate::denies(PermissionEnum::BANNER_ACCESS->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$content['title'] = $this->title;
		$content['headers'] = ["ID", "Image", "Banner Type", "Title", "Link", "Sort Order"];
		return view("admin.banners.index")->with($content);
    }

	final public function paginate(): JsonResponse {
		abort_if(Gate::denies(PermissionEnum::BANNER_ACCESS->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		return $this->bannerService->paginate();
	}

    final public function create(): View
    {
		abort_if(Gate::denies(PermissionEnum::BANNER_CREATE->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$content['title'] = $this->title;
		return view('admin.' . request()->segment(2) . '.form')->with($content);
    }

    final public function store(ManageBannerRequest $manageBannerRequest): RedirectResponse
    {
		abort_if(Gate::denies(PermissionEnum::BANNER_CREATE->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$this->bannerService->create($manageBannerRequest);
		return redirect()->route('admin.' . request()->segment(2) . '.index')->withToastSuccess('Banner Created Successfully!');
    }
    public function show($id)
    {
        //
    }

    public function edit(Banner $banner): View
	{
		abort_if(Gate::denies(PermissionEnum::BANNER_EDIT->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$title = $this->title;
		return view('admin.' . request()->segment(2) . '.form',compact('title','banner'));
    }

    public function update(ManageBannerRequest $request, Banner $banner)
    {
		abort_if(Gate::denies(PermissionEnum::BANNER_EDIT->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$this->bannerService->update($request, $banner);
		return redirect()->route('admin.' . request()->segment(2) . '.index')->withUpdatedSuccessToastr("Banner");
    }

    public function destroy(Banner $banner): JsonResponse
	{
		abort_if(Gate::denies(PermissionEnum::BANNER_DELETE->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$this->bannerService->delete($banner);
		return \response()->json('Banner Deleted Successfully!');

    }

	final public function massDestroy(MassDestroyBannerRequest $massDestroyBannerRequest): JsonResponse {
		abort_if(Gate::denies(PermissionEnum::BANNER_EDIT->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$this->bannerService->deleteMany($massDestroyBannerRequest);
		return \response()->json('Selected records Deleted Successfully.');
	}
}
