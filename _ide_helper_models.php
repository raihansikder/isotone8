<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * Class BaseModule
 *
 * @package App
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModule onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModule withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModule withoutTrashed()
 */
	class BaseModule extends \Eloquent {}
}

namespace App{
/**
 * App\Channel
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Thread[] $threads
 */
	class Channel extends \Eloquent {}
}

namespace App{
/**
 * App\Reply
 *
 * @property \Carbon\Carbon $created_at
 * @property-read \App\User $owner
 */
	class Reply extends \Eloquent {}
}

namespace App{
/**
 * App\Thread
 *
 * @property-read \App\Channel $channel
 * @property-read \App\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Reply[] $replies
 */
	class Thread extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property bool $email_confirmed
 * @property string|null $email_confirmed_at
 * @property string|null $email_confirmation_code
 * @property string|null $access_token
 * @property string|null $access_token_generated_at
 * @property string|null $api_token
 * @property string|null $api_token_generated_at
 * @property bool $tenant_editable
 * @property string|null $permissions
 * @property string|null $  groups
 * @property string|null $group_ids_csv
 * @property string|null $group_titles_csv
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccessTokenGeneratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereApiTokenGeneratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailConfirmationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGroupIdsCsv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGroupTitlesCsv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGroups($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTenantEditable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUuid($value)
 */
	class User extends \Eloquent {}
}

