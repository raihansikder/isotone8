<?php

namespace App;

use App\Observers\UserObserver;
use App\Traits\IsoModule;
use App\Traits\IsoUserPermission;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Request;

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
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[]
 *                $notifications
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
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;
    use IsoModule;
    use IsoUserPermission;

    // use Rememberable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid', 'name', 'password', 'group_ids_csv', 'email', 'tenant_id', 'email_confirmed',
        'tenant_editable', 'created_by', 'updated_by', 'deleted_by'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Validation rules. For regular expression validation use array instead of pipe
     * Example: 'name' => ['required', 'Regex:/^[A-Za-z0-9\-! ,\'\"\/@\.:\(\)]+$/']
     *
     * @param       $element
     * @param array $merge
     * @return array
     */
    public static function rules($element, $merge = [])
    {

        $rules = [
            'name' => ['required', 'between:3,255', 'unique:users,name' . (isset($element->id) ? ",$element->id" : ''), 'Regex:/^[a-z0-9\-]+$/'],
            'email' => 'required|email|unique:users,email' . (isset($element->id) ? ",$element->id" : ''),
        ];

        // While creation/registration of user password and password_confirm both should be available
        // Also if one password is given the other one should be given as well
        // While creation/registration of user password and password_confirm both should be available
        if (!isset($element->id) || (Request::has('password') && strlen(Request::get('password')))) {
            $rules = array_merge($rules, [
                'password' => 'required|between:8,32',
                'password_confirm' => 'required|between:8,32|same:password',
            ]);
        }

        return array_merge($rules, $merge);
    }

    public static $custom_validation_messages = [
        //'name.required' => 'Custom message.',
    ];

    /**
     * Allowed permissions values.
     *
     * Possible options:
     *   -1 => Deny (adds to array, but denies regardless of user's group).
     *    0 => Remove.
     *    1 => Add.
     *
     * @var array
     */
    protected $allowedPermissionsValues = array(-1, 0, 1);

    /**
     * Automatic eager load relation by default (can be expensive)
     *
     * @var array
     */
    // protected $with = ['relation1', 'relation2'];

    ############################################################################################
    # Model events
    ############################################################################################
    public static function boot()
    {
        /**
         * parent::boot() was previously used. However this invocation stops from the other classes
         * of other spyr modules(Models) to override the boot() method. Need to check more.
         * make the parent (Eloquent) boot method run.
         */
        parent::boot();
        User::observe(UserObserver::class);

        /************************************************************/
        // Following code block executes - when an element is in process
        // of creation for the first time but the creation has not
        // completed yet.
        /************************************************************/
        // static::creating(function (User $element) { });

        /************************************************************/
        // Following code block executes - after an element is created
        // for the first time.
        /************************************************************/
        // static::created(function (User $element) {});

        /************************************************************/
        // Following code block executes - when an already existing
        // element is in process of being updated but the update is
        // not yet complete.
        /************************************************************/
        // static::updating(function (User $element) {});

        /************************************************************/
        // Following code block executes - after an element
        // is successfully updated
        /************************************************************/
        //static::updated(function (User $element) {});

        /************************************************************/
        // Execute codes during saving (both creating and updating)
        /************************************************************/
        static::saving(function (User $element) {

            $valid = true;

            // Generate new api token
            if (Request::get('api_token_generate') == 'yes') {
                $element->api_token = hash('sha256', randomString(10), false);
            }

            // Create new hashed password
            if (Request::has('password') && strlen(Request::get('password'))) {
                $element->password = \Hash::make(Request::get('password'));
            }

            // Set group selection limit
            $max_groups = 5;
            if (inputIsArray('group_ids') && count(Request::get('group_ids')) > $max_groups) {
                $valid = setError("You can assign only {$max_groups} group");
            }

            // Make invalid if superuser is assigned to any specific tenant.
            $tenant_idf = tenantIdField();
            $superuser_group_id = Group::where('name', 'superuser')->remember(cacheTime('long'))->first()->id;
            if ($valid && inputIsArray('group_ids') && in_array($superuser_group_id, Request::get('group_ids', [])) && $element->$tenant_idf > 0) {
                $valid = setError("Superuser can not belong to any tenant/customer");
            }

            // Fill group_ids_csv based on group selection
            $element->group_ids_csv = null;
            $element->group_titles_csv = null;
            if ($valid && Request::has('group_ids')) {
                //$element->group_ids_csv = commaWrap(implode(',', Request::get('group_ids', []))); // Comma wrap is not necessary for single group assignment.
                $element->group_ids_csv = implode(',', Request::get('group_ids', []));
                $group_titles = [];
                foreach (Request::get('group_ids', []) as $group_id) {
                    if ($group = Group::remember(cacheTime('long'))->find($group_id)) {
                        array_push($group_titles, $group->title);
                    }
                }
                //$element->group_titles_csv = commaWrap(implode(',', $group_titles)); // Comma wrap is not necessary for single group assignment.
                $element->group_titles_csv = implode(',', $group_titles);
            }

            // fill common fields, null-fill, trim blanks from Request
            if ($valid) {
                $element->email_confirmed = (!$element->email_confirmed) ? false : true;
                $element->is_active = ($element->email_confirmed == 1) ? 1 : 0;
            }

            // if ($valid && $element->group_ids_csv != 2) {
            //     $element->tenant_id = null;
            // }

            return $valid;
        });

        /************************************************************/
        // Execute codes after model is successfully saved
        /************************************************************/
        static::saved(function (User $element) {
            $element->updateGroups($element->group_ids_csv);

            // Create a Userdetails if does not exists
            // if (!count($element->userdetail)) {
            //     Userdetail::create(['user_id' => $element->id, 'name' => $element->name]);
            // }

        });

        /************************************************************/
        // Following code block executes - when some element is in
        // the process of being deleted. This is good place to
        // put validations for eligibility of deletion.
        /************************************************************/
        // static::deleting(function (User $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully deleted.
        /************************************************************/
        // static::deleted(function (User $element) {});

        /************************************************************/
        // Following code block executes - when an already deleted element
        // is in the process of being restored.
        /************************************************************/
        // static::restoring(function (User $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully restored.
        /************************************************************/
        //static::restored(function (User $element) {});
    }

    ############################################################################################
    # Validator functions
    ############################################################################################

    /**
     * @param bool|false $setMsgSession setting it false will not store the message in session
     * @return bool
     */
    //    public function isSomethingDoable($setMsgSession = false)
    //    {
    //        $valid = true;
    //        // Make invalid(Not request-able) if {something doesn't match with something}
    //        if ($valid && $this->id == null) {
    //            if ($setMsgSession) $valid = setError("Something is wrong. Id is Null!!"); // make valid flag false and set validation error message in session if message flag is true
    //            else $valid = false; // don't set any message only set validation as false.
    //        }
    //
    //        return $valid;
    //    }

    ############################################################################################
    # Helper functions
    ############################################################################################
    /**
     * Non static functions can be directly called $element->function();
     * Such functions are useful when an object(element) is already instantiated
     * and some processing is required for that
     */
    // public function someAction() { }


    ############################################################################################
    # Permission functions
    # ---------------------------------------------------------------------------------------- #
    /*
     * This is a place holder to write the functions that resolve permission to a specific model.
     * In the parent class there are the follow functions that checks whether a user has
     * permission to perform the following on an element. Rewrite these functions
     * in case more customized access management is required.
     */
    ############################################################################################

    /**
     * Checks if the $module is viewable by current or any user passed as parameter.
     * spyrElementViewable() is the primary default checker based on permission
     * whether this should be allowed or not. The logic can be further
     * extend to implement more conditions.
     *
     * @param null $user_id
     * @return bool
     */
    //    public function isViewable($user_id = null)
    //    {
    //        $valid = false;
    //        if ($valid = spyrElementViewable($this, $user_id)) {
    //            //if ($valid && somethingElse()) $valid = false;
    //        }
    //        return $valid;
    //    }

    /**
     * Checks if the $module is editable by current or any user passed as parameter.
     * spyrElementEditable() is the primary default checker based on permission
     * whether this should be allowed or not. The logic can be further
     * extend to implement more conditions.
     *
     * @param null $user_id
     * @return bool
     */
    //    public function isEditable($user_id = null)
    //    {
    //        $valid = false;
    //        if ($valid = spyrElementEditable($this, $user_id)) {
    //            //if ($valid && somethingElse()) $valid = false;
    //        }
    //        return $valid;
    //    }

    /**
     * Checks if the $module is deletable by current or any user passed as parameter.
     * spyrElementDeletable() is the primary default checker based on permission
     * whether this should be allowed or not. The logic can be further
     * extend to implement more conditions.
     *
     * @param null $user_id
     * @return bool
     */
    //    public function isDeletable($user_id = null)
    //    {
    //        $valid = false;
    //        if ($valid = spyrElementDeletable($this, $user_id)) {
    //            //if ($valid && somethingElse()) $valid = false;
    //        }
    //        return $valid;
    //    }

    /**
     * Checks if the $module is restorable by current or any user passed as parameter.
     * spyrElementRestorable() is the primary default checker based on permission
     * whether this should be allowed or not. The logic can be further
     * extend to implement more conditions.
     *
     * @param null $user_id
     * @return bool
     */
    //    public function isRestorable($user_id = null)
    //    {
    //        $valid = false;
    //        if ($valid = spyrElementRestorable($this, $user_id)) {
    //            //if ($valid && somethingElse()) $valid = false;
    //        }
    //        return $valid;
    //    }

    ############################################################################################
    # Query scopes
    # ---------------------------------------------------------------------------------------- #
    /*
     * Scopes allow you to easily re-use query logic in your models. To define a scope, simply
     * prefix a model method with scope:
     */
    /*
       public function scopePopular($query) { return $query->where('votes', '>', 100); }
       public function scopeWomen($query) { return $query->whereGender('W'); }
       # Example of user
       $users = User::popular()->women()->orderBy('created_at')->get();
    */
    ############################################################################################

    // Write new query scopes here.

    ############################################################################################
    # Dynamic scopes
    # ---------------------------------------------------------------------------------------- #
    /*
     * Scopes allow you to easily re-use query logic in your models. To define a scope, simply
     * prefix a model method with scope:
     */
    /*
    public function scopeOfType($query, $type) { return $query->whereType($type); }
    # Example of user
    $users = User::ofType('member')->get();
    */
    ############################################################################################

    // Write new dynamic query scopes here.

    ############################################################################################
    # Model relationships
    # ---------------------------------------------------------------------------------------- #
    /*
     * This is a place holder to write model relationships. In the parent class there are
     * In the parent class there are the follow two relations creator(), updater() are
     * already defined.
     */
    ############################################################################################

    # Default relationships already available in base Class 'Basemodule'
    //public function updater() { return $this->belongsTo('User', 'updated_by'); }
    //public function creator() { return $this->belongsTo('User', 'created_by'); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups() { return $this->belongsToMany(Group::class, 'user_group'); }

    // Write new relationships below this line

    ############################################################################################
    # Accessors & Mutators
    # ---------------------------------------------------------------------------------------- #
    /*
     * Eloquent provides a convenient way to transform your model attributes when getting or setting them. Simply
     * define a getFooAttribute method on your model to declare an accessor. Keep in mind that the methods
     * should follow camel-casing, even though your database columns are snake-case:
     */
    // Example
    // public function getFirstNameAttribute($value) { return ucfirst($value); }
    // public function setFirstNameAttribute($value) { $this->attributes['first_name'] = strtolower($value); }
    ############################################################################################

    /**
     * Mutator for giving permissions.
     *
     * @param  mixed $permissions
     * @return array  $_permissions
     */
    public function getPermissionsAttribute($permissions)
    {
        if (!$permissions) {
            return array();
        }

        if (is_array($permissions)) {
            return $permissions;
        }

        if (!$_permissions = json_decode($permissions, true)) {
            throw new \InvalidArgumentException("Cannot JSON decode permissions [$permissions].");
        }

        return $_permissions;
    }

    /**
     * Mutator for taking permissions.
     *
     * @param  array $permissions
     * @return string
     */
    public function setPermissionsAttribute(array $permissions)
    {
        // Merge permissions
        $permissions = array_merge($this->permissions, $permissions);

        // Loop through and adjust permissions as needed
        foreach ($permissions as $permission => &$value) {
            // Lets make sure there is a valid permission value
            if (!in_array($value = (int)$value, $this->allowedPermissionsValues)) {
                throw new \InvalidArgumentException("Invalid value [$value] for permission [$permission] given.");
            }

            // If the value is 0, delete it
            if ($value === 0) {
                unset($permissions[$permission]);
            }
        }

        $this->attributes['permissions'] = (!empty($permissions)) ? json_encode($permissions) : '';
    }

    // Write accessors and mutators here.
}
