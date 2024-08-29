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
 * @property int $company_id
 * @property string $name
 * @property int $popularity
 * @property int $industry_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PressRelease> $press_releases
 * @property-read int|null $press_releases_count
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereIndustryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePopularity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $keyword
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PressRelease> $pressReleases
 * @property-read int|null $press_releases_count
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword query()
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereUpdatedAt($value)
 */
	class Keyword extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $release_id
 * @property int $company_id
 * @property string $title
 * @property string $summary
 * @property string $release_created_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Keyword> $keywords
 * @property-read int|null $keywords_count
 * @method static \Illuminate\Database\Eloquent\Builder|PressRelease newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PressRelease newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PressRelease query()
 * @method static \Illuminate\Database\Eloquent\Builder|PressRelease whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressRelease whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressRelease whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressRelease whereReleaseCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressRelease whereReleaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressRelease whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressRelease whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressRelease whereUpdatedAt($value)
 */
	class PressRelease extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $hash_email
 * @property string $age
 * @property string $job
 * @property string $prefecture
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ViewHistory> $view_histories
 * @property-read int|null $view_histories_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHashEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePrefecture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $score
 * @property int $user_id
 * @property int $keyword_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Keyword $keyword
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ViewHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ViewHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ViewHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ViewHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ViewHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ViewHistory whereKeywordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ViewHistory whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ViewHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ViewHistory whereUserId($value)
 */
	class ViewHistory extends \Eloquent {}
}

