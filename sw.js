// バージョン定義
var CACHE_VERSION = 'ca-v1';
var DISP_VERSION = 'ca-d-v1';

// キャッシュの対象にするディレクトリ（css/jsは個別で追加）
var resources = [
  '/',
  '/world.php',
  '/color',
  '/img',
  '/css',
  '/library',
  '/error'
];

// キャッシュ追加
self.addEventListener('install', function (event) {
  console.log('ServiceWorker Install');
  event.waitUntil(
    caches.open(CACHE_VERSION)
      .then(function (cache) {
        console.log('cache.addAll');
        cache.addAll(resources);
      })
  );
});
// キャッシュ表示
self.addEventListener('fetch', function (event) {
  //console.log('ServiceWorker fetch');
  event.respondWith(
    // キャッシュが存在するかチェック
    caches.match(event.request)
      .then(function (response) {
        if (response) {
          return response;
        } else {
          // キャッシュがない場合キャッシュに入れる
          return fetch(event.request)
            .then(function (res) {
              return caches.open(DISP_VERSION)
                .then(function (cache) {
                  //console.log('cache.put');
                  cache.put(event.request.url, res.clone());
                  return res;
                });
            })
            .catch(function () {
              // 何もしない
            });
        }
      })
  );
});
// 古いキャッシュを削除
self.addEventListener('activate', function (event) {
  //console.log('activate ServiceWorker');
  event.waitUntil(
    caches.keys()
      .then(function (keyList) {
        return Promise.all(keyList.map(function (key) {
          if (key !== CACHE_VERSION && key !== DISP_VERSION) {
            console.log('cache.delete');
            return caches.delete(key);
          }
        }));
      })
  );
  return self.clients.claim();
});