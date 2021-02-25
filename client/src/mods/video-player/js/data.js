import uuid from 'uuid'
export default function() {
	return {
		playerId: `player-${uuid()}`,
		// player: null,
		playerState: 'unstarted',
		videoHeight: 0,
		videoWidth: 0,
		duration: 0,
		currentTime: 0,
		isMuted: false,
		volume: 1,
	}
}
