module.exports = {
  productionSourceMap: false,
  outputDir: '../src/public/client',
  transpileDependencies: ['vuetify'],
  pages: {
    app: {
      entry: 'src/main.js',
      template: 'public/index.html',
      filename: 'index.html',
      title: 'Index',
      chunks: ['chunk-vendors', 'chunk-common', 'app'],
    },
    live: {
      entry: 'src/live.js',
      template: 'public/live.html',
      title: 'Live',
      chunks: ['chunk-vendors', 'chunk-common', 'live'],
    },
    embed: {
      entry: 'src/embed.js',
      // template: 'public/shortcode.html',
      // title: 'Shortcode',
      chunks: ['embed'],
    },
  },
  configureWebpack: {
    // dev: {
    //   poll: false,
    // },
  },
}
