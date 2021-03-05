export default {
  src: {
    type: String,
    default: null,
  },
  poster: {
    type: String,
    default: null,
  },
  dark: {
    type: Boolean,
    default: null,
  },

  controls: {
    type: Object,
    default: null,
  },

  timeline: {
    type: Object,
    default: null,
  },

  captions: {
    type: [Object, String],
    default: null,
  },

  // true, 'on' (starts with captions), 'always' no options
  useCaptions: {
    type: [Boolean, String],
    default: null,
  },

  // playerId: {
  // 	type: String,
  // 	default: 'mplayer',
  // },
  // aspectRatio: {
  // 	type: String,
  // 	default: null,
  // },

  noControls: {
    type: Boolean,
    default: null,
  },

  noTimeline: {
    type: Boolean,
    default: null,
  },
  noCenterPlay: {
    type: Boolean,
    default: null,
  },
  noTitle: {
    type: Boolean,
    default: null,
  },
  blockTitle: {
    type: Boolean,
    default: null,
  },

  // Value options
  useTopbar: {
    type: Boolean,
    default: null,
  },
  useShare: {
    type: Boolean,
    default: null,
  },
  delayTitleHide: {
    type: Boolean,
    default: null,
  },
  posterOnPause: {
    type: Boolean,
    default: null,
  },
  useSimplePlayBtn: {
    type: Boolean,
    default: null,
  },
  showDuration: {
    type: Boolean,
    default: null,
  },
  showProgress: {
    type: Boolean,
    default: null,
  },
  lockControls: {
    type: Boolean,
    default: null,
  },

  useLogo: {
    type: Boolean,
    default: null,
  },
  useAvatar: {
    type: Boolean,
    default: null,
  },

  color: {
    type: String,
    default: null,
  },
  inverseColor: {
    type: String,
    default: null,
  },
  controlsColor: {
    type: String,
    default: null,
  },

  titleColor: {
    type: String,
    default: null,
  },
  titleTextColor: {
    type: String,
    default: null,
  },
  // start: 0,
  // end: 0,
  // controls: ['timeline', 'center-player', 'play', 'volume', 'fullscreen'],
  title: {
    type: String,
    default: null,
  },
  // duration: true,
  // progress: true,
  // lockControls: false,

  // // logo
  logo: {
    type: Object,
    default() {
      return {}
    },
  },
  // logoPos: {
  //   type: String,
  //   default: null,
  // },
  // logoOpacity: {
  //   type: Number,
  //   default: null,
  // },
  // logoHref: {
  //   type: String,
  //   default: null,
  // },
  // linkLogo: false,
  // useLogo: false,

  // // avatar
  // avatar: {
  // 	type: String,
  // 	default: null,
  // },
  // avatarHref: {
  // 	type: String,
  // 	default: null,
  // },
  // added

  // // share
  // useShare: true,
  // shares: [],

  // Advanced
  useDecimalTime: {
    type: Boolean,
    default: null,
  },

  // remotes
  remotePause: Boolean,
  remotePlay: Boolean,
  remotePlayFromStart: Boolean,
  getInfo: Boolean,
  previewMode: Boolean,
  alwaysShowContent: Boolean,
  invisibleVideo: Boolean,
  rounded: {
    type: [String, Boolean],
    default: null,
  },
  centerPlayRounded: {
    type: [String, Boolean],
    default: null,
  },

  pauseBanner: {
    type: Object,
    default() {
      return {}
    },
  },

  promoAlert: {
    type: Object,
    default() {
      return {}
    },
  },

  isAdmin: Boolean,
  adminView: {
    type: String,
    default: '',
  },
}
