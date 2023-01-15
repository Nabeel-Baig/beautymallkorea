<?php

namespace App\Policies;

use App\Enums\AuthPermissionConstraint;
use App\Enums\PermissionEnum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Symfony\Component\HttpFoundation\Response;

class AccessPolicy {
	use HandlesAuthorization;

	/**
	 * @param User                                 $user
	 * @param Array<PermissionEnum>|PermissionEnum $permissionNames
	 * @param AuthPermissionConstraint             $constraint
	 *
	 * @return bool
	 */
	final public function access(User $user, mixed $permissionNames, AuthPermissionConstraint $constraint = AuthPermissionConstraint::AUTHORIZE_ALL): bool {
		$permissionNames = is_array($permissionNames) ? $permissionNames : [$permissionNames];
		$permissionNames = array_map(static fn($permissionName) => $permissionName->value, $permissionNames);

		$user = $this->userLoadPermissions($user, $permissionNames);

		$accessGranted = $this->userVerifyPermissions($user, $permissionNames, $constraint);

		abort_if(!$accessGranted, Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);

		return true;
	}

	/**
	 * @param User          $user
	 * @param Array<string> $permissionNames
	 *
	 * @return User
	 */
	private function userLoadPermissions(User $user, array $permissionNames): User {
		return $user->load(
			[
				"roles" => [
					"permissions" => static function (BelongsToMany $query) use ($permissionNames) {
						$query->whereIn("title", $permissionNames);
					},
				],
			],
		);
	}

	/**
	 * @param User                     $user
	 * @param Array<string>            $permissionNames
	 * @param AuthPermissionConstraint $mustIncludeAllPermissions
	 *
	 * @return bool
	 */
	private function userVerifyPermissions(User $user, array $permissionNames, AuthPermissionConstraint $mustIncludeAllPermissions): bool {
		$requiredPermissionsCount = count($permissionNames);

		if ($requiredPermissionsCount === 0) {
			return true;
		}

		$permissionTitles = [];

		foreach ($user->roles as $role) {
			foreach ($role->permissions as $permission) {
				$userHasRequiredPermission = in_array($permission->title, $permissionNames, true);

				if (!$userHasRequiredPermission) {
					continue;
				}

				$permissionTitles[$permission->title] = true;
			}
		}

		$permissionTitlesCount = count($permissionTitles);

		if ($mustIncludeAllPermissions === AuthPermissionConstraint::AUTHORIZE_ALL) {
			return $permissionTitlesCount === $requiredPermissionsCount;
		}

		return $permissionTitlesCount > 0;
	}
}
