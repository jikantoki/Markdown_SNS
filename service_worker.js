// キャッシュファイルの指定
var CACHE_NAME = 'pwa-sample-caches';
var urlsToCache = [
	'/color/Black_Orange.css',
	'/color/Black_Wine.css',
	'/color/Dark_Sea.css',
	'/color/Green.css',
	'/color/Pink.css',
	'/css/footer_style.css',
	'/css/header_style.css',
	'/css/left_style.css',
	'/css/lightbox.css',
	'/css/loader.css',
	'/css/mobile.css',
	'/css/post.css',
	'/css/reset.css',
	'/css/right_style.css',
	'/css/style.css',
	'/img/account.svg',
	'/img/account_default.png',
	'/img/ads.jpg',
	'/img/bad.svg',
	'/img/bgimg.jpg',
	'/img/dm.svg',
	'/img/dm96.svg',
	'/img/favicon.png',
	'/img/good.svg',
	'/img/home.svg',
	'/img/home96.svg',
	'/img/jikantoki.jpg',
	'/img/logout.svg',
	'/img/noimage.jpg',
	'/img/notif.svg',
	'/img/og.jpg',
	'/img/option.svg',
	'/img/post.svg',
	'/img/post_small.svg',
	'/img/post_small96.svg',
	'/img/reload.svg',
	'/img/reply.svg',
	'/img/repost.svg',
	'/img/rule.svg',
	'/img/screenshot01.png',
	'/img/screenshot02.png',
	'/img/search.svg',
	'/img/setting.png',
	'/img/setting_colored.png',
	'/img/shere.svg',
	'/img/trash.svg',
	'/img/world.svg',
	'/img/world96.svg',
	'/library/ajaxAddContent.js',
	'/library/ajaxAddPost.js',
	'/library/shortcut.js',
	'/library/text2md.js',
	'/defaultcolor.css',
	'/edit.php',
	'/editor.php',
	'/follow.php',
	'/follow_icon.php',
	'/follower.php',
	'/footer.php',
	'/header.php',
	'/index.php',
	'/left.php',
	'/post.php',
	'/readme.md',
	'/registar.php',
	'/right.php',
	'/login.php',
	'/sent_content2.php',
	'/sent_content.php',
	'/start.php',
	'/topbar.php',
	'/world.php'
];

// インストール処理
self.addEventListener('install', function(event) {
    event.waitUntil(
        caches
            .open(CACHE_NAME)
            .then(function(cache) {
                return cache.addAll(urlsToCache);
            })
    );
});

// リソースフェッチ時のキャッシュロード処理
self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches
            .match(event.request)
            .then(function(response) {
                return response ? response : fetch(event.request);
            })
    );
});

self.addEventListener("fetch", (event) => {});