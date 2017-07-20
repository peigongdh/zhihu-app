<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/7/19
 * Time: 22:18
 */

namespace App;


class Setting
{

    protected $user;

    protected $allowed = ['city', 'bio'];

    /**
     * Setting constructor.
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function merge(array $attributes)
    {
        $settings = array_merge((array)$this->user->settings, array_only($attributes, $this->allowed));
        return $this->user->update(['settings' => $settings]);
    }

}