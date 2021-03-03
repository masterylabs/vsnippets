// import config from '@/config/config'
export default {
  src: '', // plJe0uDszaY
  poster: '',

  color: '#3A3A3A', // config.colors.primary, // '#39BF6F',
  dark: true,

  // use options
  useSettings: false,
  noCenterPlay: false,
  usePlay: true,
  useVolume: true,
  useFullscreen: true,
  useTimeline: true,

  useTrim: true,

  centerPlay: {
    // xLarge: true,
    // large: true,
    fab: false,
    icon: false,
    tile: true,
    // height: 130,
  },

  // color: 'primary',

  // always one up
  noControls: false,

  lockControls: false,
  rounded: '',
  centerPlayRounded: '',
  controls: {
    align: 'end', // move timeline to end
    // iconColor: 'yellow',
    // color: 'black',
    // size: 22,
    // height: 50, // small 28, //34,
    // width: 50,
    // tile: true,
    play: true,
    timeline: true,
    captions: false,
    settings: false,
    sound: true,
    fullscreen: true,

    // items: ['play-btn', 'timeline', 'captions-btn', 'settings-btn', 'sound-btn', 'fullscreen-btn'],
    buttonDesign: {
      size: 22,
      height: 50, // small 28, //34,
      width: 50,
      tile: true,
      // rounded: 'xl',
    },
  },

  timeline: {
    showCurrentTime: true,
    showDuration: true,
    // noTooltips: true,
    // color: 'yellow',
    // height: controlsHeight,
    // background: {
    // 	// backgroundColor: 'blue',
    // 	opacity: 0.5,
    // },
    // progress: {
    // 	// backgroundColor: 'green',
    // },
    // preview: {
    // 	backgroundColor: '',
    // 	borderRight: 'solid 1px white',
  },

  useCaptions: false,
  captions: {
    // tracks: [
    //     {
    //         src: 'http://localhost:8080/captions.vtt',
    //         isDefault: true,
    //         // activeCues: [
    //         //     {
    //         //         line: -4,
    //         //     },
    //         // ],
    //     },
    // ],
    // index: -1,
    tracklist: [],
  },

  mouseOverDelay: 2500,

  // advanced
  useDecimalTime: true,

  //
  // inverseColor: '#ffffff',
  // controlsColor: '#ffffff',

  // titleColor: '#212121FF',
  // titleTextColor: '#ffffff',

  // useTopbar: true,
  // blockTitle: false,
  // delayTitleHide: true,
  posterOnPause: false,
  // useSimplePlayBtn: false,
  // title: '',
  // showDuration: true,
  // showProgress: true,
  // lockControls: false,

  // noControls: false,
  // noTimeline: false,
  // noTitle: false,
  // noFullscreen: true,

  // // logo
  // logo: '',
  // logoPos: 'tr',
  // logoOpacity: 0.5,
  // logoHref: '',
  // useLogo: false,

  // // avatar
  avatar: '',
  avatarHref: '',

  // // share
  // useShare: false,

  // aspectRatio: '16/9',
}
