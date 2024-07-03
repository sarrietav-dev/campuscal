<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $date_start
 * @property string $date_end
 * @property int $space_id
 * @property int $booking_id
 * @property-read \App\Models\Booking $booking
 * @property-read \App\Models\Space $space
 * @method static \Database\Factories\AppointmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereUpdatedAt($value)
 */
	class Appointment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Booking> $bookings
 * @property-read int|null $bookings_count
 * @method static \Database\Factories\AudienceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Audience newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Audience newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Audience query()
 * @method static \Illuminate\Database\Eloquent\Builder|Audience whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audience whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audience whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audience whereUpdatedAt($value)
 */
	class Audience extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $details
 * @property string|null $external_details
 * @property int $minors
 * @property int $agreement_contract
 * @property int $assistance
 * @property string|null $observations
 * @property string $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\File> $agreementContracts
 * @property-read int|null $agreement_contracts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Appointment> $appointments
 * @property-read int|null $appointments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audience> $audience
 * @property-read int|null $audience_count
 * @property-read \App\Models\Requester|null $requester
 * @method static \Database\Factories\BookingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereAgreementContract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereAssistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereExternalDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereMinors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereObservations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUpdatedAt($value)
 */
	class Booking extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\File> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Space> $spaces
 * @property-read int|null $spaces_count
 * @method static \Database\Factories\CampusFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Campus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Campus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Campus query()
 * @method static \Illuminate\Database\Eloquent\Builder|Campus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campus whereUpdatedAt($value)
 */
	class Campus extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $path
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Booking> $booking
 * @property-read int|null $booking_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Campus> $campus
 * @property-read int|null $campus_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Space> $space
 * @property-read int|null $space_count
 * @method static \Database\Factories\FileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File query()
 * @method static \Illuminate\Database\Eloquent\Builder|File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUpdatedAt($value)
 */
	class File extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\PermissionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $phone
 * @property string $identification
 * @property string $company_name
 * @property string $company_role
 * @property string $academic_unit
 * @property int $booking_id
 * @property-read \App\Models\Booking $booking
 * @method static \Database\Factories\RequesterFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Requester newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Requester newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Requester query()
 * @method static \Illuminate\Database\Eloquent\Builder|Requester whereAcademicUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Requester whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Requester whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Requester whereCompanyRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Requester whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Requester whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Requester whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Requester whereIdentification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Requester whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Requester wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Requester whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Requester whereUpdatedAt($value)
 */
	class Requester extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\RoleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property int $capacity
 * @property int $campus_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Appointment> $appointments
 * @property-read int|null $appointments_count
 * @property-read \App\Models\Campus|null $campus
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\File> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SpaceResource> $resources
 * @property-read int|null $resources_count
 * @method static \Database\Factories\SpaceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Space newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Space newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Space query()
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereCampusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereUpdatedAt($value)
 */
	class Space extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Space> $spaces
 * @property-read int|null $spaces_count
 * @method static \Database\Factories\SpaceResourceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceResource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceResource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceResource query()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceResource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceResource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceResource whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceResource whereUpdatedAt($value)
 */
	class SpaceResource extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed|null $password
 * @property string|null $google_id
 * @property string|null $google_token
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGoogleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGoogleToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

