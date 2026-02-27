<x-sidebar>
  <div class="vh-100 pt-5" style="background:#ECF1F6;">
    <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
      <div class="w-75 m-auto border" style="border-radius:5px;">

        <p class="text-center">{{ $calendar->getTitle() }}</p>
        <div class="">
          {!! $calendar->render() !!}
        </div>
      </div>
      <div class="text-right w-75 m-auto">
        <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
      </div>
    </div>
  </div>
  <div id="cancelModal" class="modal">
    <div class="modal__bg" id="modalBg"></div>

    <div class="modal__content">
      <p>予約日：<span id="modalDate"></span></p>
      <p>時間：<span id="modalTime"></span></p>
      <p>上記の予約をキャンセルしてもよろしいですか？</p>

      <form method="POST" action="{{ route('deleteParts') }}" id="modalDeleteForm">
        @csrf
        <input type="hidden" name="reserve_setting_id" id="modalReserve">
        <button type="button" id="modalClose" class="btn btn-primary px-4">閉じる</button>
        <button type="submit" class="btn btn-danger">キャンセル</button>
      </form>
    </div>
  </div>
</x-sidebar>
