module.exports = {
  title: "Eloquent Metrics",
  description:
    "Manage media library with a directory system and associate files with Eloquent models.",
  base: "/eloquent-metrics/",
  themeConfig: {
    logo: "/logo.png",
    repo: "moirei/eloquent-metrics",
    repoLabel: "Github",
    docsRepo: "moirei/eloquent-metrics",
    docsDir: "docs",
    docsBranch: "master",
    sidebar: [
      {
        title: "Installation",
        path: "/installation",
      },
      // {
      //   title: "Metrics",
      //   collapsable: true,
      //   children: [
      //     "/metrics/value",
      //     {
      //       title: "Trend",
      //       // path: "/metrics/trend/",
      //       // collapsable: true,
      //       children: [
      //         "/metrics/trend/count",
      //         // "/metrics/trend/average",
      //         // "/metrics/trend/sum",
      //         // "/metrics/trend/max",
      //         // "/metrics/trend/min",
      //       ],
      //     },
      //     "/metrics/partition",
      //     ,
      //   ],
      // },
      {
        title: "Value Metric",
        path: "/metrics/value",
      },
      {
        title: "Trend Metric",
        collapsable: true,
        path: "/metrics/trend/",
        children: [
          "/metrics/trend/count",
          "/metrics/trend/average",
          "/metrics/trend/sum",
          "/metrics/trend/max",
          "/metrics/trend/min",
        ],
      },
      {
        title: "Partition Metric",
        path: "/metrics/partition",
      },
      {
        title: "Examples",
        collapsable: true,
        children: ["/examples/chartisan"],
      },
    ],
    nav: [{ text: "Home", link: "/" }],
  },
  head: [
    ["link", { rel: "icon", href: "/logo.png" }],
    // ['link', { rel: 'manifest', href: '/manifest.json' }],
    ["meta", { name: "theme-color", content: "#3eaf7c" }],
    ["meta", { name: "apple-mobile-web-app-capable", content: "yes" }],
    [
      "meta",
      { name: "apple-mobile-web-app-status-bar-style", content: "black" },
    ],
    ["link", { rel: "apple-touch-icon", href: "/icons/apple-touch-icon.png" }],
    // ['link', { rel: 'mask-icon', href: '/icons/safari-pinned-tab.svg', color: '#3eaf7c' }],
    [
      "meta",
      {
        name: "msapplication-TileImage",
        content: "/icons/android-chrome-192x192.png",
      },
    ],
    ["meta", { name: "msapplication-TileColor", content: "#000000" }],
  ],
  plugins: [
    "@vuepress/register-components",
    "@vuepress/active-header-links",
    "@vuepress/pwa",
    [
      "@vuepress/search",
      {
        searchMaxSuggestions: 10,
      },
    ],
    "seo",
  ],
};
