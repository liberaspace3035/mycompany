/**
 * LiberaSpace — お問い合わせフォーム 受付スクリプト
 * https://developers.google.com/apps-script
 *
 * 役割
 *   1. サイトのフォーム（/contact/）から送信された内容を受け取る
 *   2. スプレッドシートに1行ずつ記録する
 *   3. LiberaSpace へ通知メールを送る
 *   4. 送信者へ自動返信メールを送る
 *
 * 設置手順は _docs/gas/README.md を参照。
 */

// ============================================================
// 設定 — ここだけ書き換えれば運用できます
// ============================================================
const CONFIG = {
  // 記録先のスプレッドシートID。
  // https://docs.google.com/spreadsheets/d/★ここ★/edit の ★ の部分。
  // スプレッドシートの「拡張機能 → Apps Script」から作った場合は '' のままで動きます。
  SHEET_ID: '1j_1dvQ9yAxlkYy-22uY0Yrxp6RELhoPpf6V33BiC6l4',
  SHEET_NAME: 'お問い合わせ一覧',

  // 自動返信の差出人名。差出人アドレスはスクリプトを動かすGoogleアカウントになります。
  FROM_NAME: 'LiberaSpace（リベラスペース）',

  // 通知の送り先
  NOTIFY_TO: 'liberaspace3035@gmail.com',

  // このオリジンからの送信だけ受け付けます（いたずら送信の抑止）。空配列 [] にすると無制限。
  ALLOWED_ORIGINS: [
    'https://www.liberaspace.net',
    'https://liberaspace.net',
    'http://localhost:8000'
  ],

  // 同一メールアドレスからの連続送信を弾く間隔（秒）
  DUPLICATE_WINDOW_SEC: 60
};

// フォームで選べるお問い合わせの種類（入力値の検証に使います）
const TOPICS = [
  'ホームページ制作', '保守・運用', 'SEO・AI引用対策', 'AI導入サポート', '資料請求', 'その他'
];
const DEFAULT_TOPIC = 'その他';

// スプレッドシートの列（順番を変えるとシートの並びも変わります）
const COLUMNS = [
  ['timestamp', '受付日時'],
  ['topic',     'お問い合わせの種類'],
  ['company',   '会社名・屋号'],
  ['name',      'お名前'],
  ['email',     'メールアドレス'],
  ['tel',       '電話番号'],
  ['message',   'お問い合わせ内容'],
  ['page',      '送信元ページ'],
  ['status',    '対応状況']
];


// ============================================================
// エントリポイント
// ============================================================

function doGet() {
  return json_({ ok: true, message: 'LiberaSpace お問い合わせフォーム受付：稼働中' });
}

function doPost(e) {
  try {
    const data = parseBody_(e);

    // ハニーポット：人間には見えない項目。埋まっていれば自動送信とみなし、
    // 攻撃側に気づかれないよう成功を装って破棄します。
    if (data.website) return json_({ ok: true });

    checkOrigin_(data.origin);
    validate_(data);
    checkDuplicate_(data.email);

    const record = normalize_(data);
    appendRow_(record);
    notifyOwner_(record);
    replyToSender_(record);

    return json_({ ok: true });

  } catch (err) {
    console.error(err && err.stack ? err.stack : err);
    return json_({ ok: false, message: String((err && err.message) || err) });
  }
}


// ============================================================
// 入力の取り出しと検証
// ============================================================

/**
 * ブラウザからは Content-Type: text/plain で送ってもらいます。
 * application/json にすると CORS のプリフライト(OPTIONS)が発生し、
 * Apps Script はこれに応答できないため送信が失敗します。
 */
function parseBody_(e) {
  if (e && e.postData && e.postData.contents) {
    try { return JSON.parse(e.postData.contents); } catch (_) { /* 下へ */ }
  }
  if (e && e.parameter) return e.parameter;
  throw new Error('送信内容を読み取れませんでした。');
}

function checkOrigin_(origin) {
  if (!CONFIG.ALLOWED_ORIGINS.length) return;
  if (origin && CONFIG.ALLOWED_ORIGINS.indexOf(origin) >= 0) return;
  throw new Error('このページからの送信は受け付けていません。');
}

function validate_(d) {
  const required = { name: 'お名前', email: 'メールアドレス', message: 'お問い合わせ内容' };
  for (const key in required) {
    if (!String(d[key] || '').trim()) throw new Error(required[key] + 'を入力してください。');
  }
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(String(d.email).trim())) {
    throw new Error('メールアドレスの形式が正しくありません。');
  }
  for (const key in d) {
    if (String(d[key] || '').length > 4000) throw new Error('入力が長すぎます。');
  }
}

/** 二重クリックや再送信による重複登録を防ぐ */
function checkDuplicate_(email) {
  const cache = CacheService.getScriptCache();
  const key = 'sent_' + Utilities.base64Encode(String(email).toLowerCase());
  if (cache.get(key)) throw new Error('送信済みです。しばらく経ってからお試しください。');
  cache.put(key, '1', CONFIG.DUPLICATE_WINDOW_SEC);
}

function normalize_(d) {
  const t = (v) => String(v == null ? '' : v).trim();
  return {
    timestamp: Utilities.formatDate(new Date(), 'Asia/Tokyo', 'yyyy/MM/dd HH:mm:ss'),
    topic: TOPICS.indexOf(d.topic) >= 0 ? d.topic : DEFAULT_TOPIC,
    company: t(d.company),
    name: t(d.name),
    email: t(d.email),
    tel: t(d.tel),
    message: t(d.message),
    page: t(d.page),
    status: '未対応'
  };
}


// ============================================================
// スプレッドシートへの記録
// ============================================================

function appendRow_(r) {
  const lock = LockService.getScriptLock();
  lock.waitLock(20000);                       // 同時送信で行が壊れるのを防ぐ
  try {
    // 先頭が = + - @ の値は数式として解釈されないよう ' を付ける
    const safe = (v) => /^[=+\-@]/.test(String(v)) ? "'" + v : v;
    getSheet_().appendRow(COLUMNS.map(c => safe(r[c[0]] || '')));
  } finally {
    lock.releaseLock();
  }
}

function book_() {
  return CONFIG.SHEET_ID
    ? SpreadsheetApp.openById(CONFIG.SHEET_ID)
    : SpreadsheetApp.getActiveSpreadsheet();
}

function getSheet_() {
  const ss = book_();
  let sheet = ss.getSheetByName(CONFIG.SHEET_NAME);
  if (!sheet) sheet = ss.insertSheet(CONFIG.SHEET_NAME);
  if (sheet.getLastRow() === 0) {
    if (/^無題/.test(ss.getName())) ss.rename('LiberaSpace お問い合わせ');
    const header = COLUMNS.map(c => c[1]);
    sheet.appendRow(header);
    sheet.getRange(1, 1, 1, header.length).setFontWeight('bold').setBackground('#efece6');
    sheet.setFrozenRows(1);
    sheet.setColumnWidth(1, 150);   // 受付日時
    sheet.setColumnWidth(7, 420);   // お問い合わせ内容
  }
  return sheet;
}


// ============================================================
// メール送信
// ============================================================

function notifyOwner_(r) {
  const body = [
    'サイトからお問い合わせがありました。',
    '',
    '──────────────────────────────',
    '受付日時　　　： ' + r.timestamp,
    '種類　　　　　： ' + r.topic,
    '会社名・屋号　： ' + (r.company || '（未入力）'),
    'お名前　　　　： ' + r.name,
    'メール　　　　： ' + r.email,
    '電話番号　　　： ' + (r.tel || '（未入力）'),
    '送信元ページ　： ' + (r.page || '（不明）'),
    '',
    'お問い合わせ内容：',
    r.message,
    '──────────────────────────────',
    '',
    'お問い合わせ一覧： ' + book_().getUrl(),
    '',
    '※ このメールに返信すると、お問い合わせいただいた方へ届きます。'
  ].join('\n');

  GmailApp.sendEmail(CONFIG.NOTIFY_TO,
    '【お問い合わせ】' + r.topic + '／' + (r.company ? r.company + ' ' : '') + r.name + ' 様',
    body, { name: CONFIG.FROM_NAME, replyTo: r.email });
}

function replyToSender_(r) {
  const body = [
    (r.company ? r.company + '\n' : '') + r.name + ' 様',
    '',
    'このたびは、LiberaSpace（リベラスペース）にお問い合わせいただき、',
    'ありがとうございます。',
    '',
    '以下の内容で承りました。',
    '内容を確認のうえ、2〜3営業日以内にご連絡いたします。',
    (r.topic === '資料請求' ? '資料は、ご返信の際にあわせてお送りします。\n' : ''),
    '──────────────────────────────',
    '種類　　　　： ' + r.topic,
    '会社名・屋号： ' + (r.company || '（未入力）'),
    'お名前　　　： ' + r.name,
    'メール　　　： ' + r.email,
    '電話番号　　： ' + (r.tel || '（未入力）'),
    '',
    'お問い合わせ内容：',
    r.message,
    '──────────────────────────────',
    '',
    '本メールは自動でお送りしています。',
    '追加のご連絡は、このメールにそのままご返信ください。',
    '',
    'LiberaSpace（リベラスペース）　加藤 真生',
    CONFIG.NOTIFY_TO,
    'https://www.liberaspace.net/'
  ].join('\n');

  GmailApp.sendEmail(r.email, '【LiberaSpace】お問い合わせを承りました', body,
    { name: CONFIG.FROM_NAME, replyTo: CONFIG.NOTIFY_TO });
}


// ============================================================
// 共通
// ============================================================

function json_(obj) {
  return ContentService.createTextOutput(JSON.stringify(obj))
    .setMimeType(ContentService.MimeType.JSON);
}


// ============================================================
// 設置後の動作確認用（エディタ上で実行してください）
// ============================================================

/** シートへの記録とメール送信が通るかを、テストデータで確認します（自分宛に届きます）。 */
function テスト送信() {
  const r = normalize_({
    topic: 'ホームページ制作', company: 'テスト株式会社', name: 'テスト 太郎',
    email: Session.getActiveUser().getEmail(), tel: '090-0000-0000',
    message: '（テスト送信）', page: 'エディタからのテスト'
  });
  appendRow_(r);
  notifyOwner_(r);
  replyToSender_(r);
  console.log('テスト送信しました。シートと受信箱をご確認ください。');
}
