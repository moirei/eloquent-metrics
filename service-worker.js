/**
 * Welcome to your Workbox-powered service worker!
 *
 * You'll need to register this file in your web app and you should
 * disable HTTP caching for this file too.
 * See https://goo.gl/nhQhGp
 *
 * The rest of the code is auto-generated. Please don't update this file
 * directly; instead, make changes to your Workbox build configuration
 * and re-run your build process.
 * See https://goo.gl/2aRDsh
 */

importScripts("https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js");

self.addEventListener('message', (event) => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});

/**
 * The workboxSW.precacheAndRoute() method efficiently caches and responds to
 * requests for URLs in the manifest.
 * See https://goo.gl/S9QRab
 */
self.__precacheManifest = [
  {
    "url": "404.html",
    "revision": "708b3c9ef8d6ddabacc86b37d12e75f3"
  },
  {
    "url": "assets/css/0.styles.49981eb9.css",
    "revision": "7b5a6b0646b66a1630cf119c918d4292"
  },
  {
    "url": "assets/img/search.83621669.svg",
    "revision": "83621669651b9a3d4bf64d1a670ad856"
  },
  {
    "url": "assets/js/10.43dbb17d.js",
    "revision": "3b9e11c23e60b6c16c27848040275bdf"
  },
  {
    "url": "assets/js/11.798677c2.js",
    "revision": "b704210239e320991676bf3ce556d86a"
  },
  {
    "url": "assets/js/12.07e8cebe.js",
    "revision": "77436f61f17a09a2175c67a60b0c75e8"
  },
  {
    "url": "assets/js/13.39d0f925.js",
    "revision": "d62d98402402c48564a045ae29700367"
  },
  {
    "url": "assets/js/14.dbed9139.js",
    "revision": "9a9faea38a1679454d3cab3597d6397e"
  },
  {
    "url": "assets/js/15.6ac89c31.js",
    "revision": "7e3b08e455cca20409abc855dfdab1f9"
  },
  {
    "url": "assets/js/16.336143ac.js",
    "revision": "f28551450fe9871137e9d6e384b7d6a7"
  },
  {
    "url": "assets/js/17.3445b818.js",
    "revision": "c3dc9f1ae5121e3a32f779cfa535f39a"
  },
  {
    "url": "assets/js/18.b70045ff.js",
    "revision": "d692f54f4da397ea67328b924a6d7344"
  },
  {
    "url": "assets/js/19.25edb7c2.js",
    "revision": "8a9256e7e7d2c3a2e4f06a6ae13b5c83"
  },
  {
    "url": "assets/js/2.e22ee8e9.js",
    "revision": "cbed2ed15481b149e47d4faab59abf1b"
  },
  {
    "url": "assets/js/20.e28fbea6.js",
    "revision": "141ace6e6cf519a3d06c13be10233707"
  },
  {
    "url": "assets/js/21.543955aa.js",
    "revision": "c8dee589f0ca0ecb050fa9d1e7fdc0c6"
  },
  {
    "url": "assets/js/22.af2ae836.js",
    "revision": "aac659b00c4c7d5109b35ea91dc5fe24"
  },
  {
    "url": "assets/js/23.218b26af.js",
    "revision": "82a0fd45d7dab640de09db976771f556"
  },
  {
    "url": "assets/js/3.af039bc0.js",
    "revision": "e7c1127ca5d139941aebe7bd98763d68"
  },
  {
    "url": "assets/js/4.7bd0e979.js",
    "revision": "ba5eb7cc188fb486b6b77c3d28af20c2"
  },
  {
    "url": "assets/js/5.b8254b2c.js",
    "revision": "b2f83d4a323b1cccabcf6b780abb804c"
  },
  {
    "url": "assets/js/6.10d24408.js",
    "revision": "3486daf8876e68f8f2c47eb0cd611478"
  },
  {
    "url": "assets/js/7.2143f453.js",
    "revision": "7d95a487a4ada9e2e4abc1be2498cf32"
  },
  {
    "url": "assets/js/8.c00e4699.js",
    "revision": "e3548f561fc645764db4dd41c1b97df5"
  },
  {
    "url": "assets/js/9.ec24a7db.js",
    "revision": "387d27edb549dd6816fa59cdb9e61f04"
  },
  {
    "url": "assets/js/app.021d1ba2.js",
    "revision": "d649690e875125e81b81fe8764827a12"
  },
  {
    "url": "examples/chartisan.html",
    "revision": "71e9fa92990bb2330f02b1cfd5b45828"
  },
  {
    "url": "icons/android-chrome-192x192.png",
    "revision": "50cb7c8563aa01f6ef2a9b52fb0f6842"
  },
  {
    "url": "icons/android-chrome-512x512.png",
    "revision": "bd62a95e1537d352c6e7d2fa4b4e0cc8"
  },
  {
    "url": "icons/apple-touch-icon.png",
    "revision": "3798b55457a4c8e02eb44bcb292b0728"
  },
  {
    "url": "icons/favicon-16x16.png",
    "revision": "1b90ea6862052bcfa42861cb165a5f60"
  },
  {
    "url": "icons/favicon-32x32.png",
    "revision": "191d7a0526f56ee6876ed11e64029fc1"
  },
  {
    "url": "index.html",
    "revision": "4fb6d3f75131e8c8fbe91fc663e7c011"
  },
  {
    "url": "installation.html",
    "revision": "bf2a7e5cdce31610119b8664a7d258f5"
  },
  {
    "url": "logo.png",
    "revision": "f85abcf1a181e1196ed7bedbf88cc273"
  },
  {
    "url": "metrics/partition.html",
    "revision": "3da7d11b147808786c3a1ece84a610f0"
  },
  {
    "url": "metrics/period-metric.html",
    "revision": "cd8cec429ffe1129f4200c716549b71c"
  },
  {
    "url": "metrics/trend/average.html",
    "revision": "6d70598673dfc91e4a019d5350fc90fb"
  },
  {
    "url": "metrics/trend/count.html",
    "revision": "fad397e563e26c19db74a62af55d1c12"
  },
  {
    "url": "metrics/trend/index.html",
    "revision": "b34fcdfc59c246ef334781d944fbc28e"
  },
  {
    "url": "metrics/trend/max.html",
    "revision": "7ce96ca9b348e40c05fb246e9d2c23fd"
  },
  {
    "url": "metrics/trend/min.html",
    "revision": "b4ae3057086dd2c59ed9798675db8943"
  },
  {
    "url": "metrics/trend/sum.html",
    "revision": "20f3504a99377b2e8cb3dcc782033857"
  },
  {
    "url": "metrics/value.html",
    "revision": "833a15de2fcd8348f010fc70b5996c2a"
  },
  {
    "url": "result-types/partition.html",
    "revision": "87cdf9aad67bfb774b21df12a7869056"
  },
  {
    "url": "result-types/trend.html",
    "revision": "82fac792cd5d0c566664155ad22a2db3"
  },
  {
    "url": "result-types/value.html",
    "revision": "cfdd18ebb696e6962e607027c70d375d"
  }
].concat(self.__precacheManifest || []);
workbox.precaching.precacheAndRoute(self.__precacheManifest, {});
addEventListener('message', event => {
  const replyPort = event.ports[0]
  const message = event.data
  if (replyPort && message && message.type === 'skip-waiting') {
    event.waitUntil(
      self.skipWaiting().then(
        () => replyPort.postMessage({ error: null }),
        error => replyPort.postMessage({ error })
      )
    )
  }
})
