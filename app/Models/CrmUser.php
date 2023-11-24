<?php


namespace App\Models;


use App\Helpers\DateTimeHelper;
use Brackets\AdminAuth\Models\AdminUser;
use App\Notifications\ActivationNotification;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\Reminder;
use Illuminate\Support\Facades\Auth;

class CrmUser extends AdminUser
{

    protected $table = "crm_user";

    protected $appends = ['full_name', 'resource_url','avatar_thumb_url'];

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'activated',
        'forbidden',
        'language',
        'last_login_at',
        'ipfilter'
    ];

    protected $hidden = ["media"];

    public function getResourceUrlAttribute()
    {
        return url('/admin/users/' . $this->getKey());
    }

    /**
     * Get url of avatar image
     *
     * @return string|null
     */
    public function getAvatarThumbUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('avatar', 'thumb_150') ?: null;
    }


    /**
     * Send the activation notification. (override of CanActivate sendActivationNotification)
     *
     * @param string $token
     * @return void
     */
    public function sendActivationNotification(string $token): void
    {
        $this->notify(app(ActivationNotification::class, ['token' => $token]));
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(app(ResetPasswordNotification::class, ['token' => $token]));
    }


    public function campaigns()
    {
        return $this->belongsToMany('App\Models\Campagna', 'crm_user_has_campagna', 'crm_user', 'campagna');
    }


    public function partners()
    {
        return $this->belongsToMany('App\Models\Partner', 'crm_user_has_partner', 'crm_user', 'partner');
    }


    public function hasCampaign($cid)
    {
        $v = $this->campaigns()->get()->pluck("id")->toArray();
        return in_array($cid, $v);
    }

    public function hasPartner($pid)
    {
        $v = $this->partners()->get()->pluck("id")->toArray();
        return in_array($pid, $v);
    }

    public function hasPartnerCampaign($pid, $cid)
    {
        $v = count($this->partners()->where("id", "=", $pid)
            ->where(function ($query) use ($cid) {
                $query->whereHas("campaigns", function ($query) use ($cid) {
                    $query->where("partner_has_campagna.campagna", "=", $cid);
                });
            })->get()->toArray());

        return $v > 0;
    }

    public function scopeAllAssignedPartners($query)
    {
        $query->whereHas("partners", function ($query) {
            $query->where("crm_user_has_partner.crm_user", Auth::user()->id);
        });

        return $query;
    }

    public function scopeAllAssignedCampaigns($query)
    {

        $query->whereHas("campaigns", function ($query) {
            $query->where("crm_user_has_campagna.crm_user", Auth::user()->id);
        });

        return $query;
    }


    public function scopeSamePartnerOfCurrentUser($query)
    {
        $query->whereHas("partners", function ($query) {
            $query->whereIn("crm_user_has_partner.partner", Partner::allAssignedPartners()->get()->pluck("id")->toArray());
        });

        return $query;
    }

    public function scopeSameCampaignsOfCurrentUser($query)
    {
        $query->whereHas("campaigns", function ($query) {
            $query->whereIn("crm_user_has_campagna.campagna", Campagna::allUserCampaigns()->get()->pluck("id")->toArray());
        });

        return $query;
    }


    public function scopeHasPartnerAndCampaign($query, $pid, $cid)
    {

        $query->where(function ($query) use ($cid) {
            $query->whereHas("campaigns", function ($query) use ($cid) {
                $query->where("crm_user_has_campagna.campagna", $cid);
            });
        });

        $query->whereHas("partners", function ($query) use ($pid, $cid) {
            $query->where("crm_user_has_partner.partner", $pid);
            $query->whereHas("campaigns", function ($query) use ($cid) {
                $query->where("partner_has_campagna.campagna", $cid);
            });
        });

        return $query;
    }


    public function hasAssignedCampaigns()
    {
        $c = count(Campagna::allAssignedCampaigns()->get()->toArray());
        return $c > 0;
    }

    public function hasAssignedPartners()
    {
        $c = count(Partner::allAssignedPartners()->get()->toArray());
        return $c > 0;
    }


    public function getCampagnaDropdownValues()
    {
        if (Auth::user()->hasRole("Admin")) return Campagna::select(["id","nome"])->get()->makeHidden(["resource_url","logo_thumb_url"]);
        return Campagna::select(["id","nome"])->allUserCampaigns()->get()->makeHidden(["resource_url","logo_thumb_url"]);
    }

    public function getPartnerDropdownValues($getAll = true, $hideCampaign=true)
    {
        $toHide = ["resource_url","logo_thumb_url"];
        if($hideCampaign) $toHide[] = "campaigns";

        if (Auth::user()->hasRole("Admin")) return Partner::select(["id","nome"])->get()->makeHidden($toHide);

        return Partner::select(["id","nome"])->allUserPartner($getAll)->get()->makeHidden($toHide);
    }




}
