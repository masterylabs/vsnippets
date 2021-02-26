const fields = [
  {
    text: 'Name',
    value: 'name',
  },
  {
    text: 'Description',
    value: 'description',
    type: 'textarea',
  },
  {
    text: 'Video',
    value: 'src',
    component: 'm-video-field',
  },
  {
    text: 'Image',
    value: 'image',
  },
]

export default {
  endpoint: 'videos',
  fields,
  onCreate: (form) => {
    const content = {}
    if (form.src) content.src = form.src
    if (form.poster) content.image = form.poster
    form.content = JSON.stringify(content)
    return form
  },
  onUpdate: (form) => {
    console.log('onUpdate', form, fields)
  },
}
