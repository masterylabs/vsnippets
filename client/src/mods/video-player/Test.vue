<template>
  <div>
    <div class="title mb-8">
      Video Player Test
    </div>

    <video-player v-bind="video"></video-player>

    <v-btn v-for="item in videos" :key="item.value" @click="setVideo(item.value)" v-text="item.text" />

    <div class="mt-8">
      <dev-raw :value="video" />
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        video: {
          src: '90mj79GqWhc',
          poster: 'https://i.ytimg.com/vi/kYVbHh9BigU/maxresdefault.jpg',
          color: '#39BF6F',
          dark: true,
        },

        videoFull: {
          dark: false,
          color: 'yellow',
          lockControls: true,
          // dark: true,
          // noCenterPlay: false,
          // // dark: false,
          // // color: 'yellow',
          // useCaptions: true, // 'on', //true,// 'always',// 'on',
          // startWithCaptions: true,

          src: '90mj79GqWhc', // 'L9Cgaa8U4eY', // iceman tedtalk // bmw 'Y5_6V7E6PXA',
          //	'https://player.vimeo.com/external/504032931.sd.mp4?s=0831d290c54825a6edbfcae3abde39e74c5bf889&profile_id=165',
          // src: 'https://www.dropbox.com/s/kr9h38xhsawuknp/countdown.mp4?raw=1', //'Y5_6V7E6PXA', //'kYVbHh9BigU',
          poster: 'https://i.ytimg.com/vi/kYVbHh9BigU/maxresdefault.jpg',
          // avatarx: 'https://img.youtube.com/vi/dJuAA0zttBM/2.jpg',
          // avatarLink: '',
          // posterOnPause: false,

          // timeline: {
          //   // color: 'red',
          //   // height: 25,
          // },

          // centerPlay: {
          //   size: 10,
          // },

          // mouseOverDelay: 100,

          // lockControls: true,
          // controls: {
          //   items: ['play-btn', 'timeline', 'captions-btn', 'settings-btn', 'sound-btn', 'fullscreen-btn'],
          // },
          // color: '',
          // start: 0,
          // end: 0,
          // controls: ['timeline', 'center-player', 'play', 'volume', 'fullscreen'],
          // title: 'My Video Title',
          // duration: true,
          // progress: true,
          // lockControls: true,
          // logo: '',
          // logoPos: 'tr',
          // logoOpacity: 0.5,
          // logoLink: '',
          // linkLogo: false,
          // useLogo: false,
        },
        videos: [
          {
            text: 'MP4',
            value: 'https://www.dropbox.com/s/kr9h38xhsawuknp/countdown.mp4?raw=1',
          },
          {
            text: 'Mountain (yt)',
            value: '9em32dDnTck',
          },
          {
            text: 'BMW (yt)',
            value: 'Y5_6V7E6PXA',
          },
          {
            text: 'Bear (Vimeo)',
            value: '14213714',
          },
        ],
      }
    },

    methods: {
      setVideo(src) {
        this.video.src = src
      },
    },

    mounted() {
      // setInterval(() => {
      //   this.video.noCenterPlay = !this.video.noCenterPlay
      // }, 400)
    },
  }
</script>
