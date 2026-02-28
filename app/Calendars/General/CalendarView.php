<?php

namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView
{

  private $carbon;
  function __construct($date)
  {
    $this->carbon = new Carbon($date);
  }

  public function getTitle()
  {
    return $this->carbon->format('Y年n月');
  }

  function render()
  {
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks();
    foreach ($weeks as $week) {
      $html[] = '<tr class="' . $week->getClassName() . '">';

      $days = $week->getDays();
      foreach ($days as $day) {
        $ymd = $day->everyDay();
        if (empty($ymd)) {
          $html[] = '<td class="calendar-td ' . $day->getClassName() . '">';
          $html[] = $day->render();
          // $html[] = $day->getDate();
          $html[] = '</td>';
          continue;
        }

        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        $html[] = '<td class="calendar-td ' . $day->getClassName() . '">';
        $html[] = $day->render();

        $target = Carbon::parse($ymd)->startOfDay();
        $today  = now()->startOfDay();

        if ($target->lt($today)) {
          if (in_array($day->everyDay(), $day->authReserveDay())) {
            $reservePart = $day->authReserveDate($ymd)->first()->setting_part;

            $label = $reservePart == 1 ? '1部' : ($reservePart == 2 ? '2部' : '3部');

            $html[] = '<span class="past-reserve">' . $label . '参加</span>';
          } else {
            $html[] = '<span class="past-closed">受付終了</span>';
          }

          // $html[] = $day->getDate();
          $html[] = '</td>';
          continue;
        }

        if (in_array($ymd, $day->authReserveDay())) {

          $reserve = $day->authReserveDate($ymd)->first();

          $reservePartNum = $reserve->setting_part;
          $reservePart = $reservePartNum == 1 ? 'リモ1部' : ($reservePartNum == 2 ? 'リモ2部' : 'リモ3部');

          $reserveId = $reserve->id;

          $html[] = '<button type="button" class="btn btn-danger p-0 w-75 cancel-btn" style="font-size:12px"'
            . ' data-date="' . e($ymd) . '"'
            . ' data-time="' . e($reservePart) . '"'
            . ' data-reserve="' . e($reserveId) . '">'
            . e($reservePart)
            . '</button>';
        } else {
          $html[] = '<input type="hidden" name="getData[]" value="' . e($ymd) . '" form="reserveParts">';
          $html[] = $day->selectPart($ymd);
        }
        // $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">' . csrf_field() . '</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">' . csrf_field() . '</form>';

    return implode('', $html);
  }

  protected function getWeeks()
  {
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while ($tmpDay->lte($lastDay)) {
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
