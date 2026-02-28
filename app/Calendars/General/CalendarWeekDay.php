<?php

namespace App\Calendars\General;

use App\Models\Calendars\ReserveSettings;
use Carbon\Carbon;
use Auth;

class CalendarWeekDay
{
  protected $carbon;

  function __construct($date)
  {
    $this->carbon = new Carbon($date);
  }

  function getClassName()
  {
    return "day-" . strtolower($this->carbon->format("D"))
      . " "
      . $this->pastClassName();
  }

  function pastClassName()
  {
    if ($this->carbon->isPast() && !$this->carbon->isToday()) {
      return "past-day";
    }
    return "";
  }

  /**
   * @return
   */

  function render()
  {
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function selectPart($ymd)
  {
    $target = Carbon::parse($ymd)->startOfDay();
    $today  = now()->startOfDay();

    if ($target->lt($today)) {
      $myReserve = ReserveSettings::where('setting_reserve', $target->toDateString())
        ->whereHas('users', function ($q) {
          $q->where('users.id', auth()->id());
        })
        ->first();

      if ($myReserve) {
        return '<span class="past-reserve">参加した部数：' . $myReserve->setting_part . '部</span>';
      }
      return '<span class="past-closed">受付終了</span>';
    }

    $one_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    $two_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    $three_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();
    if ($one_part_frame) {
      $one_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first()->limit_users;
    } else {
      $one_part_frame = '0';
    }
    if ($two_part_frame) {
      $two_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first()->limit_users;
    } else {
      $two_part_frame = '0';
    }
    if ($three_part_frame) {
      $three_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first()->limit_users;
    } else {
      $three_part_frame = '0';
    }

    $html = [];
    $html[] = '<select name="getPart[]" class="border-primary" style="width:70px; border-radius:5px;" form="reserveParts">';
    $html[] = '<option value="" selected></option>';
    if ($one_part_frame == "0") {
      $html[] = '<option value="1" disabled>リモ1部(残り0枠)</option>';
    } else {
      $html[] = '<option value="1">リモ1部(残り' . $one_part_frame . '枠)</option>';
    }
    if ($two_part_frame == "0") {
      $html[] = '<option value="2" disabled>リモ2部(残り0枠)</option>';
    } else {
      $html[] = '<option value="2">リモ2部(残り' . $two_part_frame . '枠)</option>';
    }
    if ($three_part_frame == "0") {
      $html[] = '<option value="3" disabled>リモ3部(残り0枠)</option>';
    } else {
      $html[] = '<option value="3">リモ3部(残り' . $three_part_frame . '枠)</option>';
    }
    $html[] = '</select>';
    return implode('', $html);
  }

  // function getDate()
  // {
  //   return $this->carbon->format('');
  // }

  function everyDay()
  {
    return $this->carbon->format('Y-m-d');
  }

  function authReserveDay()
  {
    return Auth::user()->reserveSettings->pluck('setting_reserve')->toArray();
  }

  function authReserveDate($reserveDate)
  {
    return Auth::user()->reserveSettings->where('setting_reserve', $reserveDate);
  }
}
