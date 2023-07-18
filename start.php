<!--<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>-->
<!-- 初代app -->
<link rel="manifest" href="/manifest.json">
    <script>
    // service workerの登録関係
    if ('serviceWorker' in navigator) {
	    navigator.serviceWorker.register('/service_worker.js').then(function(registration) {
	        console.log('ServiceWorker registration successful with scope: ', registration.scope);
	    }).catch(function(err) {
	        console.log('ServiceWorker registration failed: ', err);
	    });
    }
    // vue.jsの設定関係
    /*var app = new Vue({
      el: '#app',
      data: {
        message: 'Hello Vue!'
      },
      methods: {
        reverseMessage: function () {
          this.message = this.message.split('').reverse().join('')
        }
      }
    });*/
    </script>
    

<!-- 二代目app -->
    <script>
        // ServiceWorkerを読み込ませる
        window.addEventListener('load', function () {
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/sw.js')
                    .then(function (registration) {
                        return registration.pushManager.getSubscription().then(function (subscription) {
                            console.log("subscription", subscription)
                            if (subscription) {
                                return subscription
                            }
                            return registration.pushManager.subscribe({
                                userVisibleOnly: true
                            })
                        })
                    }).then(function (subscription) {
                        var endpoint = subscription.endpoint
                        console.log("pushManager endpoint:", endpoint)
                    }).catch(function (error) {
                        console.log("serviceWorker error:", error)
                    })
            }
        })
    </script>