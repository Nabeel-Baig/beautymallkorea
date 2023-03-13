<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banner\ManageBannerRequest;
use App\Models\Banner;
use App\Services\BannerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    final public function store(ManageBannerRequest $request): RedirectResponse
    {
		Banner::create(handleFiles(\request()->segment(2), $request->validated()));
		return redirect()->route('admin.' . request()->segment(2) . '.index')->withToastSuccess('Banner Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
