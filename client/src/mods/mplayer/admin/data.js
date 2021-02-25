export default function() {
	return {
		ready: false,
		isAdvanced: false,
		isChanged: false,
		val: {
			color: '',
		},
		color: '#39BF6F', // #F60402
		inverseColor: '#ffffff',
		fields: [
			{
				text: 'Video Id',
				value: 'src',
				placeholder: 'Video file or YouTube ID',
				// hide: () => this.noVideo,
			},
			{
				text: 'Poster',
				value: 'poster',
				placeholder: 'https://video-image',
				hide: () => this.noPoster,
			},
			{
				text: 'Video Title',
				value: 'title',
				placeholder: 'YouTube title used by default',
				hide: () => !this.advanced,
			},
			// {
			// 	text: 'Avatar',
			// 	value: 'avatar',
			// 	placeholder: 'https://profile-image',
			// },
			// {
			// 	text: 'Avatar Link',
			// 	value: 'avatarHref',
			// 	placeholder: 'https://profile-link',
			// 	hide: () => {
			// 		return !this.val.avatar
			// 	},
			// },
			{
				text: 'Aspect Ratio',
				value: 'aspectRatio',
				placeholder: '16/9',
				hide: () => !this.advanced,
			},
		],
		options: [
			// {
			// 	text: 'Enable Share',
			// 	value: 'useShare',
			// },
			// {
			// 	text: 'Disable Title',
			// 	value: 'noTitle',
			// 	advanced: true,
			// },
			{
				text: 'Hide Controls',
				value: 'noControls',
				advanced: false,
			},
			{
				text: 'Hide Timeline',
				value: 'noTimeline',
				advanced: true,
			},
			{
				text: 'Preview Play',
				value: 'isPreview',
				advanced: true,
			},
			{
				text: 'Poster on Pause',
				value: 'posterOnPause',
				advanced: true,
			},
			{
				text: 'Simple Play Button',
				value: 'useSimplePlayBtn',
				advanced: true,
			},
		],
		colors: [
			{
				text: 'Theme Color',
				value: 'color',
				defaultValue: '#39BF6F',
			},
			{
				text: 'Inverse Color',
				value: 'inverseColor',
				defaultValue: '#ffffff',
				advanced: true,
			},
			{
				text: 'Controls Color',
				value: 'controlsColor',
				defaultValue: '#ffffff',
				advanced: true,
			},
			// {
			// 	text: 'Title Color',
			// 	value: 'titleColor',
			// 	defaultValue: '#212121FF',
			// 	advanced: true,
			// },
			// {
			// 	text: 'Title Text Color',
			// 	value: 'titleTextColor',
			// 	defaultValue: '#ffffff',
			// 	advanced: true,
			// },
		],
	}
}
