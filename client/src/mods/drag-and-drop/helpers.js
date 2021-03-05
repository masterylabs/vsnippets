// getGif
// const getGifUrl = (dataTransfer, no = false) => {
//   let html = dataTransfer.getData('text/html')

//   if (!html) return no

//   if (html.indexOf('id="mouseover-overlay"') > -1) {
//     html = html.split('id="mouseover-overlay"')[1]
//   }

//   const regex = /(?<=src=").*?(?=")/
//   let src = html.match(regex)[0]

//   if (!src || src.indexOf('://') < 0) return no

//   return src.replace(/&amp;/g, '&')
// }

const getYtId = (v, def = false) => {
  if (v.length === 11 && v.indexOf('.') < 0) {
    return v
  }

  const regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/
  const match = v.match(regExp)
  if (match && match[2].length == 11) {
    return match[2]
  }
  return def
}

const getStudioInfo = (dataTransfer) => {
  const url = dataTransfer.getData('URL')

  const [, a] = url.split('/video/')
  const [videoId] = a.split('/')

  return {
    gif: false,
    videoId,
  }
}

export const getThumbInfo = (dataTransfer, no = false) => {
  if (!dataTransfer) return no

  const videoUrl = dataTransfer.getData('URL')

  if (videoUrl.indexOf('https://studio.youtube.com/video/') > -1) {
    return getStudioInfo(dataTransfer)
  }

  // const gif = getGifUrl(dataTransfer)
  const thumb = {
    // gif,
    videoUrl, // dataTransfer.getData('URL'),
  }

  thumb.videoId = thumb.videoUrl ? getYtId(thumb.videoUrl) : false

  return thumb
}

export const loadImage = (url) => {
  return new Promise((resolve, reject) => {
    const image = new Image()

    const onSuccess = () => {
      resolve({ width: image.width, height: image.height })
    }

    const onFail = (e) => {
      reject()
    }

    image.onload = onSuccess
    image.onerror = onFail
    image.src = url
  })
}

export const createId = (prefix = 'thumb_') => {
  return (
    prefix +
    Math.random()
      .toString(36)
      .substr(2, 9)
  )
}
