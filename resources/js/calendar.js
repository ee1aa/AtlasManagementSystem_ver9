console.log('calendar.js loaded');
document.addEventListener('DOMContentLoaded', () => {
  // 予約画面にモーダルが無いページでは何もしない
  const modal = document.getElementById('cancelModal');
  if (!modal) return;

  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.cancel-btn');
    if (!btn) return;

    const dateEl = document.getElementById('modalDate');
    const timeEl = document.getElementById('modalTime');
    const reserveEl = document.getElementById('modalReserve');

    if (dateEl) dateEl.textContent = btn.dataset.date ?? '';
    if (timeEl) timeEl.textContent = btn.dataset.time ?? '';
    if (reserveEl) reserveEl.value = btn.dataset.reserve ?? '';

    modal.style.display = 'block';
  });

// 背景クリックで閉じる
document.getElementById('modalBg')?.addEventListener('click', () => {
  document.getElementById('cancelModal').style.display = 'none';
});

// 戻るボタン
document.getElementById('modalClose')?.addEventListener('click', () => {
  document.getElementById('cancelModal').style.display = 'none';
});

});
