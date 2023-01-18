<?php

namespace App\Services\Datatables;

use App\Enums\PermissionEnum;
use BadFunctionCallException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\DataTables;

class DataTableService {
	private string|null $model = null;

	/**
	 * @var Array<string>|null
	 */
	private array|null $columns = null;

	/**
	 * @var Array<string, bool>
	 */
	private array $additionalColumns = [
		"selection" => false,
		"viewAction" => false,
		"editAction" => false,
		"deleteAction" => false,
	];

	public function __construct(
		private readonly Request $request,
		private readonly DataTables $dataTables,
	) {}

	final public function of(string $model): DataTableService {
		$this->model = $model;

		return $this;
	}

	/**
	 * @param Array<string> $columns
	 *
	 * @return DataTableService
	 */
	final public function withColumns(array $columns): DataTableService {
		$this->columns = $columns;

		return $this;
	}

	final public function withSelectionColumn(): DataTableService {
		$this->additionalColumns["selection"] = true;

		return $this;
	}

	final public function withViewAction(PermissionEnum $permission): DataTableService {
		/*if ($this->request->user()->cannot("access", [$this->model, $permission])) {
			return $this;
		}*/

		$this->additionalColumns["viewAction"] = true;

		return $this;
	}

	final public function withEditAction(PermissionEnum $permission): DataTableService {
		/*if ($this->request->user()->cannot("access", [$this->model, $permission])) {
			return $this;
		}*/

		$this->additionalColumns["editAction"] = true;

		return $this;
	}

	final public function withDeleteAction(PermissionEnum $permission): DataTableService {
		/*if ($this->request->user()->cannot("access", [$this->model, $permission])) {
			return $this;
		}*/

		$this->additionalColumns["deleteAction"] = true;

		return $this;
	}

	final public function paginate(string $routeModelName): JsonResponse {
		if (is_null($this->model)) {
			throw new BadFunctionCallException('Argument $builder is missing. Call "of" method on the DataTableService instance with Illuminate\Database\Eloquent\Builder parameter first');
		}

		/** @noinspection PhpUndefinedMethodInspection */
		$datatableBuilder = $this->dataTables->eloquent($this->model::query());

		$datatableBuilder = $this->includeDesiredColumns($datatableBuilder);
		[$datatableBuilder, $selectionIncluded] = $this->includeSelectionColumn($datatableBuilder);
		[$datatableBuilder, $actionsIncluded] = $this->includeActionsColumn($datatableBuilder, $routeModelName);
		$datatableBuilder = $this->prepareRawColumnsList($datatableBuilder, $selectionIncluded, $actionsIncluded);

		return $datatableBuilder->make();
	}

	private function includeDesiredColumns(DataTableAbstract $dataTable): DataTableAbstract {
		if (!is_null($this->columns)) {
			$dataTable = $dataTable->only($this->columns);
		}

		return $dataTable;
	}

	/**
	 * @param DataTableAbstract $dataTable
	 *
	 * @return array [DataTableAbstract, boolean]
	 */
	private function includeSelectionColumn(DataTableAbstract $dataTable): array {
		if (!$this->additionalColumns["selection"]) {
			return [$dataTable, false];
		}

		$dataTable = $dataTable->addColumn("selection", "components.datatables.checkbox-column");
		return [$dataTable, true];
	}

	/**
	 * @param DataTableAbstract $dataTable
	 * @param string            $routeModelName
	 *
	 * @return array [DataTableAbstract, boolean]
	 */
	private function includeActionsColumn(DataTableAbstract $dataTable, string $routeModelName): array {
		$additionalColumns = $this->additionalColumns;
		if (!$additionalColumns["viewAction"] && !$additionalColumns["editAction"] && !$additionalColumns["deleteAction"]) {
			return [$dataTable, false];
		}

		$dataTable = $dataTable->addColumn("actions", $this->generateActionsColumn($routeModelName));
		return [$dataTable, true];
	}

	private function generateActionsColumn(string $routeModelName): callable {
		return function (Model $model) use ($routeModelName) {
			$actions = [];

			if ($this->additionalColumns["viewAction"]) {
				$actions[] = $this->generateViewButtonTemplate($model);
			}

			if ($this->additionalColumns["editAction"]) {
				$actions[] = $this->generateEditButtonTemplate($model, $routeModelName);
			}

			if ($this->additionalColumns["deleteAction"]) {
				$actions[] = $this->generateDeleteButtonTemplate($model);
			}

			return implode("", $actions);
		};
	}

	private function generateViewButtonTemplate(Model $model): string {
		$id = $model->getKey();

		return "
			<button title='View' type='button' id='view-$id' class='view btn btn-info btn-sm'>
				<i class='fa fa-eye'></i>
			</button>
		";
	}

	private function generateEditButtonTemplate(Model $model, string $routeModelName): string {
		$id = $model->getKey();
		$route = route("admin.$routeModelName.edit", $id);

		return "
			<a title='Edit' id='edit-$id' href='$route' class='btn btn-primary btn-sm'>
				<i class='fas fa-pen'></i>
			</a>
		";
	}

	private function generateDeleteButtonTemplate(mixed $model): string {
		$id = $model->getKey();

		return "
			<button title='Delete' type='button' id='delete-$id' class='delete btn btn-danger btn-sm'>
				<i class='fa fa-trash'></i>
			</button>
		";
	}

	private function prepareRawColumnsList(DataTableAbstract $dataTable, bool $selectionIncluded, bool $actionsIncluded): DataTableAbstract {
		$rawColumns = [];

		if ($selectionIncluded) {
			$rawColumns[] = "selection";
		}

		if ($actionsIncluded) {
			$rawColumns[] = "actions";
		}

		return $dataTable->rawColumns($rawColumns);
	}
}
